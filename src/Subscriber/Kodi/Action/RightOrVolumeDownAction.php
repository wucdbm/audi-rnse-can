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

namespace Wucdbm\AudiRnseCan\Subscriber\Kodi\Action;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\Apps\Kodi\KodiControls;
use Wucdbm\AudiRnseCan\Reader\RNSEButtonAction;

readonly class RightOrVolumeDownAction implements RNSEButtonAction
{
    public function __construct(
        private OutputInterface $output,
        private KodiControls $controls,
    ) {
    }

    public function short(): void
    {
        $this->controls->right();
        $this->output->writeln('KodiRNSESubscriber down short');
    }

    public function hold(int $times): bool
    {
        $volume = $this->controls->volumeDown();

        if ($volume) {
            $this->output->writeln(sprintf(
                'KodiRNSESubscriber volume down to %d%%',
                $volume->getVolume(),
            ));
        } else {
            $this->output->writeln('KodiRNSESubscriber failed to decrease volume');
        }

        return true;
    }

    public function long(): void
    {
    }
}
