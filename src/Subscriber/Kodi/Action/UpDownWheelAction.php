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
use Wucdbm\AudiRnseCan\Reader\RNSEWheel;

readonly class UpDownWheelAction implements RNSEWheel
{
    public function __construct(
        private OutputInterface $output,
        private KodiControls $controls,
    ) {
    }

    public function wheelLeft(): void
    {
        $this->controls->down();
        $this->output->writeln('KodiRNSESubscriber left');
    }

    public function wheelRight(): void
    {
        $this->controls->up();
        $this->output->writeln('KodiRNSESubscriber right');
    }
}
