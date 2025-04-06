<?php declare(strict_types=1);
/*
 * Copyright (C) 2025-2025 Martin Kirilov
 *
 * Developed and maintained at https://github.com/wucdbm/audi-rnse-can
 *
 * Use as you like, as a library or as a direct solution
 *
 * Inspiration and documentation for the CAN codes mainly found at
 * https://github.com/peetereczek/openauto-audi-api
 * https://www.janssuuh.nl/en/skin-audi-rns-full-beta/
 */

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
    ) {
        $this->short = $short;
        $this->hold = $hold;
        $this->long = $long;
    }

    public function press(): void
    {
        ++$this->state;

        if ($this->state >= 2) {
            $hold = $this->hold;
            $hold($this->state);
        }
    }

    public function release(): void
    {
        if (0 === $this->state) {
            return;
        }

        $short = $this->short;
        $long = $this->long;

        if ($this->state >= $this->longThreshold) {
            $long();
        } else {
            $short();
        }

        $this->state = 0;
    }
}
