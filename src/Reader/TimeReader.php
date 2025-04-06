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
use Symfony\Component\Process\Process;
use Wucdbm\AudiRnseCan\CanBusFrame;

class TimeReader implements Reader
{
    private bool $timeSet = false;

    public function __construct(
        private readonly OutputInterface $output,
    ) {
    }

    public function read(CanBusFrame $frame): void
    {
        if (0x623 !== $frame->getId()) {
            return;
        }

        if (true === $this->timeSet) {
            return;
        }

        $this->output->writeln(sprintf(
            'TimeListener read "%s"',
            $frame->toString()
        ));

        $arg = sprintf(
            '%s%s%s%s%s.%s',
            $frame->substring(10, 2),
            $frame->substring(8, 2),
            $frame->substring(2, 2),
            $frame->substring(4, 2),
            $frame->substring(12, 4),
            $frame->substring(6, 2),
        );

        $process = new Process(['sudo', 'date', $arg]);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->output->writeln(sprintf(
                'TimeListener: Failed to set date: "%s"',
                $process->getErrorOutput(),
            ));
        } else {
            $this->output->writeln(sprintf(
                'TimeListener: Set time successfully to "%s"',
                $arg
            ));
        }
    }
}
