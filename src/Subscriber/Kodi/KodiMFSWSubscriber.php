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

use Wucdbm\AudiRnseCan\Apps\Kodi\HTTPJSONRPCKodiControls;
use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Reader\MFSWSubscriber;

readonly class KodiMFSWSubscriber implements MFSWSubscriber
{
    public function __construct(
        private HTTPJSONRPCKodiControls $controls
    ) {
    }

    public function onWheelUp(CanBusFrame $frame): void
    {
        $this->controls->right();
    }

    public function onWheelDown(CanBusFrame $frame): void
    {
        $this->controls->left();
    }

    public function onButtonUpHold(CanBusFrame $frame): void
    {
        $this->controls->seekBackward();
    }

    public function onButtonDownHold(CanBusFrame $frame): void
    {
        $this->controls->seekForward();
    }

    public function onWheelShortPress(CanBusFrame $frame): void
    {
        $this->controls->select();
    }

    public function onWheelLongPress(CanBusFrame $frame): void
    {
        $this->controls->escape();
    }
}
