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

readonly class GearChangeReader implements Reader
{
    public function __construct(
        private OutputInterface $output,
        private GearChangeSubscriber $subscriber,
    ) {
    }

    public function read(CanBusFrame $frame): void
    {
        if (0x351 !== $frame->getId()) {
            return;
        }

        $this->output->writeln(sprintf(
            'GearChangeListener read "%s"',
            $frame->toString()
        ));

        $msg = $frame->substring(0, 2);

        match ($msg) {
            '00' => $this->onForwardGear($frame),
            '02' => $this->onReverseGear($frame),
            default => ''
        };
    }

    private function onForwardGear(CanBusFrame $frame): void
    {
        $this->subscriber->onForwardGear($frame);
        $this->output->writeln('GearChangeListener Forward Gear Engaged');
    }

    private function onReverseGear(CanBusFrame $frame): void
    {
        $this->subscriber->onReverseGear($frame);
        $this->output->writeln('GearChangeListener Reverse Gear Engaged');
    }
}
