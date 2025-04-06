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

namespace Wucdbm\AudiRnseCan;

readonly class CanBusFrame
{
    /**
     * @param int[] $data
     */
    public function __construct(
        private int $id,
        private array $data,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function getDataString(): string
    {
        return implode('', array_map(
            fn ($a) => str_pad(strtoupper(dechex($a)), 2, '0', STR_PAD_LEFT),
            $this->data
        ));
    }

    public function byte(int $index): ?int
    {
        return $this->data[$index] ?? null;
    }

    public function substring(int $offset, ?int $length = null): string
    {
        return substr($this->getDataString(), $offset, $length);
    }

    public function toString(): string
    {
        $idString = strtoupper(dechex($this->id));
        $bytesString = $this->getDataString();

        return sprintf(
            '%s#%s',
            $idString,
            $bytesString,
        );
    }
}
