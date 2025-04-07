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

class CarModelReader implements Reader
{
    public function __construct(
        private readonly OutputInterface $output,
        private readonly CarModelContainer $container,
    ) {
    }

    public function read(CanBusFrame $frame): void
    {
        if (0x65F !== $frame->getId()) {
            return;
        }

        if ($this->isDetected()) {
            return;
        }

        $this->output->writeln(sprintf(
            'CarModelListener read "%s"',
            $frame->toString()
        ));

        $firstTwo = substr($frame->getDataString(), 0, 2);

        if ('01' !== $firstTwo) {
            // I actually don't know, python code did that
            return;
        }

        $modelData = substr($frame->getDataString(), 8, 4);
        $yearData = substr($frame->getDataString(), 14, 2);

        $model = hex2bin($modelData);

        if (false === $model) {
            $this->output->writeln(sprintf(
                'CarModelListener WARNING: Could not read car model data: "%s"',
                $frame->toString()
            ));

            return;
        }

        $this->container->setModel($model);
        $this->container->setYear((int)hexdec($yearData) + 2000);
    }

    public function isDetected(): bool
    {
        return null !== $this->container->getModel() && null !== $this->container->getYear();
    }
}
