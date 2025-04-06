<?php

namespace Wucdbm\AudiRnseCan;

use Wucdbm\AudiRnseCan\Reader\Reader;

readonly class CanReader
{

    /**
     * @param CanBusConnection $can
     * @param Reader[] $readers
     */
    public function __construct(
        private CanBusConnection $can,
        private array $readers,
    )
    {
    }

    public function read(): void
    {
        while ($frame = $this->can->read()) {
            foreach ($this->readers as $reader) {
                $reader->read($frame);
            }
        }
    }

}
