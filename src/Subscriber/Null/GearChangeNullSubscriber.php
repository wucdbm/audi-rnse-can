<?php

namespace Wucdbm\AudiRnseCan\Subscriber\Null;

use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Reader\GearChangeSubscriber;

class GearChangeNullSubscriber implements GearChangeSubscriber
{
    public function onForwardGear(CanBusFrame $frame): void
    {
    }

    public function onReverseGear(CanBusFrame $frame): void
    {
    }

}
