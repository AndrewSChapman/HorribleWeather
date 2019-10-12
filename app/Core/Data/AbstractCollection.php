<?php

namespace App\Core\Data;

abstract class AbstractCollection implements \Iterator, \Countable
{
    /** @var array */
    protected $values;

    /** @var int */
    protected $iteratorPointer;

    public function __construct()
    {
        $this->values = [];
        $this->iteratorPointer = 0;
    }

    public function next(): void
    {
        $this->iteratorPointer++;
    }

    public function key(): int
    {
        return $this->iteratorPointer;
    }

    public function valid(): bool
    {
        return array_key_exists($this->iteratorPointer, $this->values);
    }

    public function rewind(): void
    {
        $this->iteratorPointer = 0;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function toArray(): array
    {
        $items = [];

        foreach ($this as $item) {
            $items[] = (string)$item;
        }

        return $items;
    }
}
