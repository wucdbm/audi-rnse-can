<?php

namespace Wucdbm\AudiRnseCan\Subscriber\Kodi;

use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Apps\Kodi\HTTPJSONRPCKodiControls;
use Wucdbm\AudiRnseCan\Reader\MFSWSubscriber;

readonly class KodiMFSWSubscriber implements MFSWSubscriber
{
    public function __construct(
        private HTTPJSONRPCKodiControls $controls
    )
    {
    }

    public function onWheelUp(CanBusFrame $frame): void
    {
        $this->controls->right();
    }

    public function onWheelDown(CanBusFrame $frame): void
    {
        $this->controls->left();
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
