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

namespace Wucdbm\AudiRnseCan\Apps\Kodi;

interface KodiControls
{
    public function left(): void;

    public function right(): void;

    public function up(): void;

    public function down(): void;

    public function select(): void;

    public function escape(): void;

    public function play(): void;

    public function pause(): void;

    public function playPause(): void;

    public function previous(): void;

    public function next(): void;

    public function setupWTF(): void;
}
