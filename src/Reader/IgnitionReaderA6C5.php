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

readonly class IgnitionReaderA6C5 implements Reader
{
    public function __construct(
        private OutputInterface $output,
        private IgnitionSubscriber $subscriber,
    ) {
    }

    public function read(CanBusFrame $frame): void
    {
        if (0x271 !== $frame->getId()) {
            return;
        }

        $this->output->writeln(sprintf(
            'IgnitionListener read "%s"',
            $frame->toString()
        ));

        $firstByte = $frame->byte(0);

        if (0x01 === $firstByte) {
            $this->subscriber->onIgnitionOff($frame);
        }

        if (0x00 === $firstByte) {
            $this->subscriber->onKeyOut($frame);
        }
    }
}
