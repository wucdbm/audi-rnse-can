<?php

namespace Wucdbm\AudiRnseCan\Reader;

class RNSEButton
{
    private int $state = 0;

    /** @var callable */
    private $short;

    /** @var callable */
    private $hold;

    /** @var callable */
    private $long;

    public function __construct(
        callable $short,
        callable $hold,
        callable $long,
        private readonly int $longThreshold,
    )
    {
        $this->short = $short;
        $this->hold = $hold;
        $this->long = $long;
    }

    public function press(): void
    {
        $this->state++;

        if ($this->state >= 2) {
            $hold = $this->hold;
            $hold($this->state);
        }
    }

    public function release(): void
    {
        $short = $this->short;
        $long = $this->long;

        if ($this->state <= $this->longThreshold) {
            $long();
        } else {
            $short();
        }

        $this->state = 0;
    }
}
