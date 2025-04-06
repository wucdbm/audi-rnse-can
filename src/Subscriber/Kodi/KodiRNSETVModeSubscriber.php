<?php

namespace Wucdbm\AudiRnseCan\Subscriber\Kodi;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Apps\Kodi\HTTPJSONRPCKodiControls;
use Wucdbm\AudiRnseCan\Reader\RNSETVModeSubscriber;

class KodiRNSETVModeSubscriber implements RNSETVModeSubscriber
{
    private bool $tvModeActive = true;

    public function __construct(
        private readonly OutputInterface $output,
       private readonly  HTTPJSONRPCKodiControls $controls,
    )
    {
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
