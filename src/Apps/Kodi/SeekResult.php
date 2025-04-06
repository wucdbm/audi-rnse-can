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
 * @phpstan-type SeekTime array{hours: int, milliseconds: int, minutes: int, seconds: int}
 * @phpstan-type SeekResultArr array{percentage: float, time: SeekTime, totaltime: SeekTime}
 * @phpstan-type SeekResponse array{id: int, jsonrpc: string, result: SeekResultArr}
 */
readonly class SeekResult
{
    /**
     * @param SeekResponse $data
     */
    public function __construct(private array $data)
    {
        // {
        //      "id":1,
        //      "jsonrpc":"2.0",
        //      "result":{
        //          "percentage":43.56003189086914,
        //          "time":{"hours":0,"milliseconds":772,"minutes":1,"seconds":29},
        //          "totaltime":{"hours":0,"milliseconds":88,"minutes":3,"seconds":26}
        //      }
        //  }
    }

    public function getTime(): string
    {
        return $this->timeToString(
            $this->data['result']['time']
        );
    }

    public function getTotalTime(): string
    {
        return $this->timeToString(
            $this->data['result']['totaltime']
        );
    }

    /**
     * @param SeekTime $time
     */
    private function timeToString(array $time): string
    {
        return sprintf(
            '%s:%s:%s',
            $time['hours'],
            $time['minutes'],
            $time['seconds'],
        );
    }
}
