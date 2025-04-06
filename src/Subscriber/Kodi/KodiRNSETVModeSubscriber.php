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

namespace Wucdbm\AudiRnseCan\Subscriber\Kodi;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\Apps\Kodi\HTTPJSONRPCKodiControls;
use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Reader\RNSETVModeSubscriber;

class KodiRNSETVModeSubscriber implements RNSETVModeSubscriber
{
    private bool $tvModeActive = true;

    public function __construct(
        private readonly OutputInterface $output,
        private readonly HTTPJSONRPCKodiControls $controls,
    ) {
    }

    public function onTvModeActive(CanBusFrame $frame): void
    {
        $this->tvModeActive = true;
        $this->controls->play();
        $this->output->writeln('KodiRNSETVModeSubscriber play');
    }

    public function onTvModeInactive(CanBusFrame $frame): void
    {
        $this->tvModeActive = false;
        $this->controls->pause();
        $this->output->writeln('KodiRNSETVModeSubscriber pause');
    }

    public function isTvModeActive(): bool
    {
        return $this->tvModeActive;
    }
}
