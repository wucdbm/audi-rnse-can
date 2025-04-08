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

readonly class RNSEReader implements Reader
{
    public function __construct(
        private OutputInterface $output,
        private RNSEButtons $buttons,
        private RNSETVModeSubscriber $tvSubscriber,
    ) {
    }

    public function read(CanBusFrame $frame): void
    {
        match ($frame->getId()) {
            0x661 => $this->onTvMode($frame),
            0x461 => $this->onKeyPress($frame),
            default => ''
        };
    }

    private function onTvMode(CanBusFrame $frame): void
    {
        $this->output->writeln(sprintf(
            'RNSEListener read "%s"',
            $frame->toString()
        ));

        if ('8101123700000000' === $frame->getDataString() || '8301123700000000' === $frame->getDataString()) {
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

        var_dump($frame->getDataString(), $frame->getData());

        //        '373001004001' => $this->buttons->wheel->wheelLeft(),
        if (str_starts_with($frame->getDataString(), '3730010040')) {
            $clicks = $frame->byte(5);
            do {
                $this->buttons->wheel->wheelLeft();
                --$clicks;
            } while ($clicks > 0);
        }

        //        '373001002001' => $this->buttons->wheel->wheelRight(),
        if (str_starts_with($frame->getDataString(), '3730010020')) {
            $clicks = $frame->byte(5);
            do {
                $this->buttons->wheel->wheelRight();
                --$clicks;
            } while ($clicks > 0);
        }

        match ($frame->getDataString()) {
            '373001400000' => $this->buttons->up->press(),
            '373004400000' => $this->buttons->up->release(),
            '373001800000' => $this->buttons->down->press(),
            '373004800000' => $this->buttons->down->release(),
            '373001001000' => $this->buttons->wheelPress->press(),
            '373004001000' => $this->buttons->wheelPress->release(),
            '373001000200' => $this->buttons->return->press(),
            '373004000200' => $this->buttons->return->release(),
            '373001020000' => $this->buttons->next->press(),
            '373004020000' => $this->buttons->next->release(),
            '373001010000' => $this->buttons->previous->press(),
            '373004010000' => $this->buttons->previous->release(),
            '373001000100' => $this->buttons->setup->press(),
            '373004000100' => $this->buttons->setup->release(),
            default => ''
        };
    }
}
