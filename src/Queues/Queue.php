<?php

declare(strict_types=1);

namespace Devinson\Architect\Queues;

/**
 * @template TValue
 */
class Queue
{
    /**
     * @var array<int,TValue>
     */
    private $queue = [];

    /**
     * @param array<array-key,TValue> $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            foreach ($data as $item) {
                $this->enqueue($item);
            }
        }
    }

    /**
     * Adds an element to the end of the queue
     *
     * @param TValue $data
     */
    public function enqueue($data): void
    {
        $this->queue[] = $data;
    }

    /**
     * Removes an element from the top of the queue
     *
     * @return null|TValue
     */
    public function dequeue()
    {
        return array_shift($this->queue);
    }

    /**
     * Search an element in the queue by given index
     *
     * @return null|TValue
     */
    public function find(int $index)
    {
        if ($this->isNotEmpty()) {
            return $this->queue[$index];
        }

        return null;
    }

    /**
     * Returns the queue as an array
     *
     * @return null|array<int,TValue>
     */
    public function toArray()
    {
        if ($this->isNotEmpty()) {
            $array = [];

            foreach ($this->queue as $element) {
                $array[] = $element;
            }

            return $array;
        }

        return null;
    }

    /**
     * Returns the first element in the queue
     *
     * @return null|TValue
     */
    public function peek()
    {
        if ($this->isNotEmpty()) {
            return $this->queue[array_key_first($this->queue)];
        }

        return null;
    }

    /**
     * Returns the last element in the queue or null if it's empty
     *
     * @return null|TValue
     */
    public function getRear()
    {
        if ($this->isNotEmpty()) {
            return $this->queue[array_key_last($this->queue)];
        }

        return null;
    }

    /**
     * Returns the queue's size
     */
    public function getSize(): int
    {
        return count($this->queue);
    }

    /**
     * Check if the queue is empty
     */
    public function isEmpty(): bool
    {
        return empty($this->queue);
    }

    /**
     * Check if the queue is not empty
     */
    public function isNotEmpty(): bool
    {
        return !empty($this->queue);
    }
}
