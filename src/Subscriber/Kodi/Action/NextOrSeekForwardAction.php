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

readonly class NextOrSeekForwardAction implements RNSEButtonAction
{
    public function __construct(
        private OutputInterface $output,
        private KodiControls $controls,
    ) {
    }

    public function short(): void
    {
        $this->controls->next();
        $this->output->writeln('KodiRNSESubscriber next short');
    }

    public function hold(int $times): bool
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

        return true;
    }

    public function long(): void
    {
    }
}
