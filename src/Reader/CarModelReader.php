<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;

class CarModelReader implements Reader
{
    private ?string $model = null;
    private ?int $year = null;

    public function __construct(
        private readonly OutputInterface $output
    )
    {
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

        $firstTwo = substr($frame->getBytesString(), 0, 2);

        if ('01' !== $firstTwo) {
            // I actually don't know, python code did that
            return;
        }

        $carModel = substr($frame->getBytesString(), 8, 4);
        $carYear = substr($frame->getBytesString(), 14, 2);

        $this->model = hex2bin($carModel);
        $this->year = (int)hexdec($carYear) + 2000;
    }

    public function isDetected(): bool
    {
        return $this->model !== null && $this->year !== null;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

}
