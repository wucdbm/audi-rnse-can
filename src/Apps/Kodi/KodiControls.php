<?php

namespace Wucdbm\AudiRnseCan\Apps\Kodi;

use GuzzleHttp\Psr7\Request;

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
