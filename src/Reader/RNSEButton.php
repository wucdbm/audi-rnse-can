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
    private bool $isReactingToHold = false;

    public function __construct(
        private readonly RNSEButtonAction $action,
        private readonly int $longThreshold,
    ) {
    }

    public function press(): void
    {
        ++$this->state;

        if ($this->state >= $this->longThreshold) {
            $this->isReactingToHold = $this->action->hold($this->state);
        }
    }

    public function release(): void
    {
        if (0 === $this->state) {
            return;
        }

        if ($this->isReactingToHold) {
            $this->reset();

            return;
        }

        if ($this->state >= $this->longThreshold) {
            $this->action->long();
        } else {
            $this->action->short();
        }

        $this->reset();
    }

    private function reset(): void
    {
        $this->state = 0;
        $this->isReactingToHold = false;
    }
}
