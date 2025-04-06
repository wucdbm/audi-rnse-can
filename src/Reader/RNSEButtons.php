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

readonly class RNSEButtons
{
    public function __construct(
        public RNSEWheel $wheel,
        public RNSEButton $up,
        public RNSEButton $down,
        public RNSEButton $wheelPress,
        public RNSEButton $return,
        public RNSEButton $next,
        public RNSEButton $previous,
        public RNSEButton $setup,
    ) {
    }
}
