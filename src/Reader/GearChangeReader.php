<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;

readonly class GearChangeReader implements Reader
{
    public function __construct(
        private OutputInterface $output,
        private GearChangeSubscriber $subscriber,
    )
    {
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
