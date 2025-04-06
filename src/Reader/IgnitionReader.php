<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;

readonly class IgnitionReader implements Reader
{

    public function __construct(
        private OutputInterface $output,
        private IgnitionSubscriber $subscriber,
    )
    {
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

        if (0x11 === $firstByte) {
            $this->subscriber->onIgnitionOff($frame);
        }

        if (0x10 === $firstByte) {
            $this->subscriber->onKeyOut($frame);
        }


    }
}
