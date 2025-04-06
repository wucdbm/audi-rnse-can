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

interface RNSETVModeSubscriber
{
    public function onTvModeActive(CanBusFrame $frame): void;

    public function onTvModeInactive(CanBusFrame $frame): void;

    public function isTvModeActive(): bool;
}
