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
use Wucdbm\AudiRnseCan\Reader\RNSESubscriber;

readonly class KodiRNSESubscriber implements RNSESubscriber
{
    public function __construct(
        private OutputInterface $output,
        private HTTPJSONRPCKodiControls $controls,
        private KodiRNSETVModeSubscriber $tvSubscriber,
    ) {
    }

    public function onScrollLeft(): void
    {
        $this->controls->down();
        $this->output->writeln('KodiRNSESubscriber left');
    }

    public function onScrollRight(): void
    {
        $this->controls->up();
        $this->output->writeln('KodiRNSESubscriber right');
    }

    public function onUpShort(): void
    {
        $this->controls->left();
        $this->output->writeln('KodiRNSESubscriber up short');
    }

    public function onUpHold(int $times): void
    {
    }

    public function onUpLong(): void
    {
        $this->controls->left();
        $this->output->writeln('KodiRNSESubscriber up long');
    }

    public function onDownShort(): void
    {
        $this->controls->right();
        $this->output->writeln('KodiRNSESubscriber down short');
    }

    public function onDownHold(int $times): void
    {
    }

    public function onDownLong(): void
    {
        $this->controls->right();
        $this->output->writeln('KodiRNSESubscriber down long');
    }

    public function onWheelShort(): void
    {
        $this->controls->select();
        $this->output->writeln('KodiRNSESubscriber enter short');
    }

    public function onWheelHold(int $times): void
    {
    }

    public function onWheelLong(): void
    {
        $this->controls->select();
        $this->output->writeln('KodiRNSESubscriber enter long');
    }

    public function onReturnShort(): void
    {
        $this->controls->escape();
        $this->output->writeln('KodiRNSESubscriber escape short');
    }

    public function onReturnHold(int $times): void
    {
    }

    public function onReturnLong(): void
    {
        $this->controls->escape();
        $this->output->writeln('KodiRNSESubscriber escape long');
    }

    public function onNextShort(): void
    {
        $this->controls->next();
        $this->output->writeln('KodiRNSESubscriber next short');
    }

    public function onNextHold(int $times): void
    {
        $seek = $this->controls->seekForward();

        if ($seek) {
            $this->output->writeln(sprintf(
                'KodiRNSESubscriber seek forward to %s of %s',
                $seek->getTime(),
                $seek->getTotalTime(),
            ));
        } else {
            $this->output->writeln('KodiRNSESubscriber failed to seek forward');
        }
    }

    public function onNextLong(): void
    {
        //        $this->controls->next();
        //        $this->output->writeln('KodiRNSESubscriber next long');
    }

    public function onPreviousShort(): void
    {
        $this->controls->previous();
        $this->output->writeln('KodiRNSESubscriber previous short');
    }

    public function onPreviousHold(int $times): void
    {
        $seek = $this->controls->seekBackward();

        if ($seek) {
            $this->output->writeln(sprintf(
                'KodiRNSESubscriber seek backward to %s of %s',
                $seek->getTime(),
                $seek->getTotalTime(),
            ));
        } else {
            $this->output->writeln('KodiRNSESubscriber failed to seek backward');
        }
    }

    public function onPreviousLong(): void
    {
        //        $this->controls->previous();
        //        $this->output->writeln('KodiRNSESubscriber previous long');
    }

    public function onSetupShort(): void
    {
        $this->controls->playPause();
        $this->output->writeln('KodiRNSESubscriber setup short');
    }

    public function onSetupHold(int $times): void
    {
    }

    public function onSetupLong(): void
    {
        $this->controls->playPause();
        $this->output->writeln('KodiRNSESubscriber setup long');
    }

    public function isTvMode(): bool
    {
        return $this->tvSubscriber->isTvModeActive();
    }
}
