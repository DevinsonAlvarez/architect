<?php

declare(strict_types=1);

namespace Devinson\Architect\Queues;

class Queue
{
    private int $front;
    private int $rear;

    /**
     * @var array<int,mixed>
     */
    private $queue = [];

    public function __construct()
    {
        $this->front = -1;
        $this->rear = -1;
    }

    /**
     * Adds an element to the end of the queue and returns its position
     */
    public function enQueue(mixed $data): int
    {
        ($this->front == -1) ? $this->front = 0 : null;

        $this->queue[++$this->rear] = $data;

        return $this->rear;
    }

    /**
     * Removes an element from the queue and returns it
     */
    public function deQueue(): mixed
    {
        if ($this->isNotEmpty()) {
            if ($this->front > $this->rear) {
                $this->front = -1;
                $this->rear = -1;

                return null;
            }

            $element = $this->queue[$this->front];
            unset($this->queue[$this->front]);
            $this->front++;

            if ($this->front > $this->rear) {
                $this->front = -1;
                $this->rear = -1;
            }

            return $element;
        }

        return null;
    }

    /**
     * Search an element in the queue by given index
     */
    public function find(int $index): mixed
    {
        if ($this->isNotEmpty()) {
            return $this->queue[$index];
        }

        return null;
    }

    /**
     * Returns the queue as an array
     *
     * @return null|array<int,mixed>
     */
    public function toArray(): ?array
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
     * Returns the first element in the queue or null if it's empty
     */
    public function getFront(): mixed
    {
        if ($this->isNotEmpty()) {
            return $this->queue[$this->front];
        }

        return null;
    }

    /**
     * Returns the last element in the queue or null if it's empty
     */
    public function getRear(): mixed
    {
        if ($this->isNotEmpty()) {
            return $this->queue[$this->rear];
        }

        return null;
    }

    /**
     * Returns the queue's size
     */
    public function getSize(): int
    {
        return ($this->rear - $this->front) + 1;
    }

    /**
     * Check if the queue is empty
     */
    public function isEmpty(): bool
    {
        return $this->front == -1;
    }

    /**
     * Check if the queue is not empty
     */
    public function isNotEmpty(): bool
    {
        return $this->front != -1;
    }
}
