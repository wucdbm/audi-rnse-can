<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Wucdbm\AudiRnseCan\CanBusFrame;

interface IgnitionSubscriber
{

    public function onIgnitionOff(CanBusFrame $frame): void;
    public function onKeyOut(CanBusFrame $frame): void;
}
