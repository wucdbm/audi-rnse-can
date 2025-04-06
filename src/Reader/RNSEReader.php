<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;

class RNSEReader implements Reader
{

    private RNSEButton $up;
    private RNSEButton $down;
    private RNSEButton $wheel;
    private RNSEButton $return;
    private RNSEButton $next;
    private RNSEButton $previous;
    private RNSEButton $setup;

    public function __construct(
        private readonly OutputInterface $output,
        private readonly RNSESubscriber $subscriber,
        private readonly RNSETVModeSubscriber $tvSubscriber,
        private readonly RNSEButtonThresholds $thresholds = new RNSEButtonThresholds()
    )
    {
        $this->up = $this->thresholds->createUpButton(
            $this->subscriber->onUpShort(...),
            $this->subscriber->onUpHold(...),
            $this->subscriber->onUpLong(...),
        );
        $this->down = $this->thresholds->createDownButton(
            $this->subscriber->onDownShort(...),
            $this->subscriber->onDownHold(...),
            $this->subscriber->onDownLong(...),
        );
        $this->wheel = $this->thresholds->createWheelButton(
            $this->subscriber->onWheelShort(...),
            $this->subscriber->onWheelHold(...),
            $this->subscriber->onWheelLong(...),
        );
        $this->return = $this->thresholds->createReturnButton(
            $this->subscriber->onReturnShort(...),
            $this->subscriber->onReturnHold(...),
            $this->subscriber->onReturnLong(...),
        );
        $this->next = $this->thresholds->createNextButton(
            $this->subscriber->onNextShort(...),
            $this->subscriber->onNextHold(...),
            $this->subscriber->onNextLong(...),
        );
        $this->previous = $this->thresholds->createPreviousButton(
            $this->subscriber->onPreviousShort(...),
            $this->subscriber->onPreviousHold(...),
            $this->subscriber->onPreviousLong(...),
        );
        $this->setup = $this->thresholds->createSetupButton(
            $this->subscriber->onSetupShort(...),
            $this->subscriber->onSetupHold(...),
            $this->subscriber->onSetupLong(...),
        );
    }

    public function read(CanBusFrame $frame): void
    {
        match ($frame->getId()) {
            0x661 => $this->onTvMode($frame),
            0x461 => $this->onKeyPress($frame),
        };
    }

    private function onTvMode(CanBusFrame $frame): void
    {
        $this->output->writeln(sprintf(
            'RNSEListener read "%s"',
            $frame->toString()
        ));

        if ('8101123700000000' === $frame->getBytesString() || '8301123700000000' === $frame->getBytesString()) {
            $this->onTvModeActive($frame);
        } else {
            $this->onTvModeInactive($frame);
        }
    }

    private function onTvModeActive(CanBusFrame $frame): void
    {
        $this->output->writeln('RNSEListener TV Mode Active');
        $this->tvSubscriber->onTvModeActive($frame);
    }

    private function onTvModeInactive(CanBusFrame $frame): void
    {
        $this->output->writeln('RNSEListener TV Mode Inactive');
        $this->tvSubscriber->onTvModeInactive($frame);
    }

    private function onKeyPress(CanBusFrame $frame): void
    {

        $this->output->writeln(sprintf(
            'MFSWListener read "%s"',
            $frame->toString()
        ));

        match ($frame->getBytesString()) {
            '373001004001' => $this->subscriber->onScrollLeft(),
            '373001002001' => $this->subscriber->onScrollRight(),
            '373001400000' => $this->up->press(),
            '373004400000' => $this->up->release(),
            '373001800000' => $this->down->press(),
            '373004800000' => $this->down->release(),
            '373001001000' => $this->wheel->press(),
            '373004001000' => $this->wheel->release(),
            '373001000200' => $this->return->press(),
            '373004000200' => $this->return->release(),
            '373001020000' => $this->next->press(),
            '373004020000' => $this->next->release(),
            '373001010000' => $this->previous->press(),
            '373004010000' => $this->previous->release(),
            '373001000100' => $this->setup->press(),
            '373004000100' => $this->setup->release(),
        };
    }


}
