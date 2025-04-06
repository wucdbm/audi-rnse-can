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

/**
 * @phpstan-type VolumeResponse array{id: int, jsonrpc: string, result: int}
 */
class VolumeResult
{
    /**
     * @param VolumeResponse $data
     */
    public function __construct(private array $data)
    {
        // {"id":1,"jsonrpc":"2.0","result":100}
    }

    public function getVolume(): int
    {
        return (int)$this->data['result'];
    }
}
