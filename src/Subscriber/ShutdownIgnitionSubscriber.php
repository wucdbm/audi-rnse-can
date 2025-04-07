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

namespace Wucdbm\AudiRnseCan\Subscriber;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Reader\IgnitionSubscriber;

readonly class ShutdownIgnitionSubscriber implements IgnitionSubscriber
{
    public function __construct(
        private OutputInterface $output
    ) {
    }

    public function onIgnitionOff(CanBusFrame $frame): void
    {
    }

    public function onKeyOut(CanBusFrame $frame): void
    {
        $process = new Process(['sudo', 'poweroff']);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->output->writeln(sprintf(
                'ShutdownIgnitionSubscriber: Failed to initiate shutdown: "%s"',
                $process->getErrorOutput(),
            ));
        }
    }
}
