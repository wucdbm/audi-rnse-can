<?php

namespace Wucdbm\AudiRnseCan\Reader;

use Wucdbm\AudiRnseCan\CanBusFrame;

interface Reader
{
    public function read(CanBusFrame $frame): void;
}
