<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Wucdbm\AudiRnseCan\CanBusFrame;

interface GearChangeSubscriber
{

    public function onForwardGear(CanBusFrame $frame): void;
    public function onReverseGear(CanBusFrame $frame): void;
}
