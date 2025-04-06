<?php declare(strict_types=1);
/*
 * Copyright (C) 2025-2025 Martin Kirilov
 *
 * Developed and maintained at https://github.com/wucdbm/audi-rnse-can
 *
 * Use as you like, as a library or as a direct solution
 *
 * Inspiration and documentation for the CAN codes mainly found at
 * https://github.com/peetereczek/openauto-audi-api
 * https://www.janssuuh.nl/en/skin-audi-rns-full-beta/
 */

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
        private readonly RNSETVModeSubscriber $tvSubscriber,
    ) {
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
            '8E/3908', '8P/3908', '8J/3908' => $this->onWheelPress(),
            default => ''
        };

        if ('3900' === $frame->getDataString() || '3A00' === $frame->getDataString()) {
            $this->onWheelRelease($frame);
        }
    }

    public function onWheelUp(CanBusFrame $frame): void
    {
        $this->press = 0;
        $this->output->writeln('MFSWListener: onWheelUp');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        $this->subscriber->onWheelUp($frame);
    }

    public function onWheelDown(CanBusFrame $frame): void
    {
        $this->press = 0;
        $this->output->writeln('MFSWListener: onWheelDown');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        $this->subscriber->onWheelDown($frame);
    }

    public function onWheelPress(): void
    {
        $this->output->writeln('MFSWListener: onWheelPress');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        ++$this->press;
    }

    public function onWheelRelease(CanBusFrame $frame): void
    {
        $this->output->writeln('MFSWListener: onWheelRelease');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            $this->press = 0;

            return;
        }

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
