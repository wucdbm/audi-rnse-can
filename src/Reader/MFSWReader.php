<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;

class MFSWReader implements Reader
{

    private bool $isDetected = false;
    private int $press = 0;

    public function __construct(
        private readonly OutputInterface $output,
        private readonly MFSWSubscriber $subscriber,
        private readonly CarModelReader $carModelListener,
    )
    {
    }

    public function read(CanBusFrame $frame): void
    {
        if (0x5C3 !== $frame->getId()) {
            return;
        }

        $this->output->writeln(sprintf(
            'MFSWListener read "%s"',
            $frame->toString()
        ));

        $this->isDetected = true;

        if (!$this->carModelListener->getModel()) {
            $this->output->writeln('MFSW Pressed, but car model not detected - abort');
            return;
        }

        $type = sprintf(
            '%s/%s',
            $this->carModelListener->getModel(),
            $frame->getDataString(),
        );

        match ($type) {
            // Scan Wheel Up
            '8E/3904', '8P/390B', '8J/390B' => $this->onWheelUp($frame),
            // Scan Wheel Down
            '8E/3905', '8P/390C', '8J/390C' => $this->onWheelDown($frame),
            // Scan Wheel Press
            '8E/3908', '8P/3908', '8J/3908' => $this->onWheelPress($frame),
        };

        if ('3900' === $frame->getDataString() || '3A00' === $frame->getDataString()) {
            $this->onWheelRelease($frame);

        }


    }

    public function onWheelUp(CanBusFrame $frame): void
    {
        $this->press = 0;
        $this->output->writeln('MFSWListener: onWheelUp');
        $this->subscriber->onWheelUp($frame);
    }

    public function onWheelDown(CanBusFrame $frame): void
    {
        $this->press = 0;
        $this->output->writeln('MFSWListener: onWheelDown');
        $this->subscriber->onWheelDown($frame);
    }

    public function onWheelPress(CanBusFrame $frame): void
    {
        $this->press++;
    }

    public function onWheelRelease(CanBusFrame $frame): void
    {
        if (0 === $this->press) {
            return;
        }

        if (1 === $this->press) {
            $this->output->writeln('MFSWListener: onWheelShortPress');
            $this->subscriber->onWheelShortPress($frame);
        } else {
            $this->output->writeln('MFSWListener: onWheelLongPress');
            $this->subscriber->onWheelLongPress($frame);
        }

        $this->press = 0;
    }

    public function isDetected(): bool
    {
        return $this->isDetected;
    }

}
