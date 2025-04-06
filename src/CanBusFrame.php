<?php

namespace Wucdbm\AudiRnseCan;

readonly class CanBusFrame
{
    /**
     * @param int[] $data
     */
    public function __construct(
        private int $id,
        private array $data,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getData(): array
    {
        return $this->data;
    }

    public function getDataString(): string
    {
        return implode('', array_map(
            fn($a) => str_pad(strtoupper(dechex($a)), 2, '0', STR_PAD_LEFT),
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
