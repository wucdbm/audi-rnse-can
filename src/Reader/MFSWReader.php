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

    // Up and down are relevant to A6 C5
    // They can be held down for a period of time
    //    private int $up = 0;
    //    private int $down = 0;
    private int $press = 0;

    public function __construct(
        private readonly OutputInterface $output,
        private readonly MFSWSubscriber $subscriber,
        private readonly CarModelContainer $carModelContainer,
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

        if (!$this->carModelContainer->getModel()) {
            $this->output->writeln('MFSW Pressed, but car model not detected - abort');

            return;
        }

        $type = sprintf(
            '%s/%s',
            $this->carModelContainer->getModel(),
            $frame->getDataString(),
        );

        match ($type) {
            // Scan Wheel Up
            '8E/3904', '8P/390B', '8J/390B' => $this->onWheelUp($frame),
            // Scan Wheel Down
            '8E/3905', '8P/390C', '8J/390C' => $this->onWheelDown($frame),
            //            // A6 C5 Button Up
            //            '4B/3902' => $this->onButtonUp($frame),
            //            // A6 C5 Button Down
            //            '4B/4903' => $this->onButtonDown($frame),
            // Scan Wheel Press
            '8E/3908', '8P/3908', '8J/3908' => $this->onWheelPress(),
            default => ''
        };

        // 3900 is MFSW idle according to janssuuh.nl
        // "Passive state Multifunction steering wheel"
        // On A6 C5, 3A00 is the telephone wheel mode idle/passive
        // TODO Both 3900 and 3A00 are MFSW idle messages
        // They are being sent regardless of what's going on
        // We should only react to those if $press is > 0
        if ('3900' === $frame->getDataString() || '3A00' === $frame->getDataString()) {
            $this->onMFSWIdle($frame);
        }
    }

    public function onWheelUp(CanBusFrame $frame): void
    {
        $this->resetState();
        $this->output->writeln('MFSWListener: onWheelUp');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        $this->subscriber->onWheelUp($frame);
    }

    public function onWheelDown(CanBusFrame $frame): void
    {
        $this->resetState();
        $this->output->writeln('MFSWListener: onWheelDown');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        $this->subscriber->onWheelDown($frame);
    }

    //    public function onButtonUp(CanBusFrame $frame): void
    //    {
    //        $this->output->writeln('MFSWListener: onButtonUp');
    //
    //        if (!$this->tvSubscriber->isTvModeActive()) {
    //            $this->output->writeln('MFSWListener: TV Mode not active, will not act');
    //
    //            return;
    //        }
    //
    //        ++$this->up;
    //
    //        if ($this->up > 1) {
    //            $this->subscriber->onButtonUpHold($frame);
    //        }
    //    }

    //    public function onButtonDown(CanBusFrame $frame): void
    //    {
    //        $this->output->writeln('MFSWListener: onButtonDown');
    //
    //        if (!$this->tvSubscriber->isTvModeActive()) {
    //            $this->output->writeln('MFSWListener: TV Mode not active, will not act');
    //
    //            return;
    //        }
    //
    //        ++$this->down;
    //
    //        if ($this->down > 1) {
    //            $this->subscriber->onButtonDownHold($frame);
    //        }
    //    }

    public function onWheelPress(): void
    {
        $this->output->writeln('MFSWListener: onWheelPress');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            return;
        }

        ++$this->press;
    }

    public function onMFSWIdle(CanBusFrame $frame): void
    {
        $this->output->writeln('MFSWListener: onMFSWIdle');

        if (!$this->tvSubscriber->isTvModeActive()) {
            $this->output->writeln('MFSWListener: TV Mode not active, will not act');

            $this->resetState();

            return;
        }

        //        if ($this->up > 0) {
        //            if (1 === $this->up) {
        //                // A6 C5 handling of buttons
        //                $this->subscriber->onButtonUpPress($frame);
        //            }
        //
        //            $this->resetState();
        //
        //            return;
        //        }

        //        if ($this->down > 0) {
        //            if (1 === $this->down) {
        //                // A6 C5 handling of buttons
        //                $this->subscriber->onButtonDownPress($frame);
        //            }
        //
        //            $this->resetState();
        //
        //            return;
        //        }

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

        $this->resetState();
    }

    private function resetState(): void
    {
        //        $this->up = 0;
        //        $this->down = 0;
        $this->press = 0;
    }

    public function isDetected(): bool
    {
        return $this->isDetected;
    }
}
