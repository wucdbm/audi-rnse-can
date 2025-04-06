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
use Wucdbm\AudiRnseCan\Reader\RNSEButton;
use Wucdbm\AudiRnseCan\Reader\RNSEButtons;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\EscapeAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\LeftOrVolumeUpAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\NextOrSeekForwardAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\PlayPauseAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\PreviousOrSeekBackwardAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\RightOrVolumeDownAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\SelectAction;
use Wucdbm\AudiRnseCan\Subscriber\Kodi\Action\UpDownWheelAction;

class KodiRNSEButtonsFactory
{
    public static function create(
        OutputInterface $output,
        HTTPJSONRPCKodiControls $controls,
    ): RNSEButtons {
        return new RNSEButtons(
            wheel: new UpDownWheelAction($output, $controls),
            up: new RNSEButton(
                new LeftOrVolumeUpAction($output, $controls),
                4,
            ),
            down: new RNSEButton(
                new RightOrVolumeDownAction($output, $controls),
                4,
            ),
            wheelPress: new RNSEButton(
                new SelectAction($output, $controls),
                4,
            ),
            return: new RNSEButton(
                new EscapeAction($output, $controls),
                4,
            ),
            next: new RNSEButton(
                new NextOrSeekForwardAction($output, $controls),
                4,
            ),
            previous: new RNSEButton(
                new PreviousOrSeekBackwardAction($output, $controls),
                4,
            ),
            setup: new RNSEButton(
                new PlayPauseAction($output, $controls),
                4,
            ),
        );
    }
}
