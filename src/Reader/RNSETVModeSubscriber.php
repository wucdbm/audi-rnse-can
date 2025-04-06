<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Wucdbm\AudiRnseCan\CanBusFrame;

interface RNSETVModeSubscriber
{

    public function onTvModeActive(CanBusFrame $frame): void;

    public function onTvModeInactive(CanBusFrame $frame): void;

    public function isTvModeActive(): bool;

}
