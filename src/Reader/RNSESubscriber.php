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

interface RNSESubscriber
{
    public function onScrollLeft(): void;

    public function onScrollRight(): void;

    public function onUpShort(): void;

    public function onUpHold(int $times): void;

    public function onUpLong(): void;

    public function onDownShort(): void;

    public function onDownHold(int $times): void;

    public function onDownLong(): void;

    public function onWheelShort(): void;

    public function onWheelHold(int $times): void;

    public function onWheelLong(): void;

    public function onReturnShort(): void;

    public function onReturnHold(int $times): void;

    public function onReturnLong(): void;

    public function onNextShort(): void;

    public function onNextHold(int $times): void;

    public function onNextLong(): void;

    public function onPreviousShort(): void;

    public function onPreviousHold(int $times): void;

    public function onPreviousLong(): void;

    public function onSetupShort(): void;

    public function onSetupHold(int $times): void;

    public function onSetupLong(): void;
}
