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

readonly class RNSEButtonThresholds
{
    public function __construct(
        private int $up = 4,
        private int $down = 4,
        private int $wheel = 4,
        private int $return = 4,
        private int $next = 4,
        private int $previous = 4,
        private int $setup = 4,
    ) {
    }

    public function createUpButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->up);
    }

    public function createDownButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->down);
    }

    public function createWheelButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->wheel);
    }

    public function createReturnButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->return);
    }

    public function createNextButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->next);
    }

    public function createPreviousButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->previous);
    }

    public function createSetupButton(
        callable $short,
        callable $hold,
        callable $long
    ): RNSEButton {
        return new RNSEButton($short, $hold, $long, $this->setup);
    }
}
