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
    public const SENSITIVITY = 4;

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

        echo sprintf(
            "\n\nButton Press State: %d | %d\n\n",
            $this->state,
            floor($this->state / self::SENSITIVITY),
        );

        if ($this->state >= 2) {
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

        $actualState = floor($this->state / self::SENSITIVITY);

        echo sprintf(
            "\n\nButton Release Actual State: %d\n\n",
            $actualState,
        );

        if ($actualState >= $this->longThreshold) {
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
