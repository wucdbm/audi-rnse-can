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

use Wucdbm\AudiRnseCan\CanBusFrame;

interface MFSWSubscriber
{
    public function onWheelUp(CanBusFrame $frame): void;

    public function onWheelDown(CanBusFrame $frame): void;

    public function onButtonUpPress(CanBusFrame $frame): void;

    public function onButtonDownPress(CanBusFrame $frame): void;

    public function onButtonUpHold(CanBusFrame $frame): void;

    public function onButtonDownHold(CanBusFrame $frame): void;

    public function onWheelShortPress(CanBusFrame $frame): void;

    public function onWheelLongPress(CanBusFrame $frame): void;
}
