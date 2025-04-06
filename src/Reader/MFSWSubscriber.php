<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Wucdbm\AudiRnseCan\CanBusFrame;

interface MFSWSubscriber
{
    public function onWheelUp(CanBusFrame $frame): void;

    public function onWheelDown(CanBusFrame $frame): void;

    public function onWheelShortPress(CanBusFrame $frame): void;

    public function onWheelLongPress(CanBusFrame $frame): void;
}
