<?php

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

    public function isTvMode(): bool;

}
