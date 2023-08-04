<?php

declare(strict_types=1);

namespace Devinson\Architect\Stacks;

class Stack
{
    private int $top = -1;

    /**
     * @var array<int,mixed>
     */
    private $stack = [];

    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (count($data) != 0) {
            foreach ($data as $item) {
                $this->push($item);
            }
        }
    }

    /**
     * Insert an element at the top of the stack
     */
    public function push(mixed $data): int
    {
        $this->stack[++$this->top] = $data;

        return $this->top;
    }

    /**
     * Remove the top stack element
     */
    public function pop(): mixed
    {
        if ($this->isNotEmpty()) {
            $popedElement = $this->stack[$this->top];
            unset($this->stack[$this->top]);
            $this->top -= 1;
            return $popedElement;
        }

        return null;
    }

    /**
     * Search an element in the stack by given index
     */
    public function find(int $index): mixed
    {
        if ($this->isNotEmpty()) {
            return $this->stack[$index];
        }

        return null;
    }

    /**
     * Return the size of the stack
     */
    public function size(): int
    {
        return $this->top + 1;
    }

    /**
     * Return the top element in the list
     */
    public function topElement(): mixed
    {
        if ($this->isNotEmpty()) {
            return $this->stack[$this->top];
        }

        return null;
    }

    /**
     * Check if the stack is empty
     */
    public function isEmpty(): bool
    {
        return $this->top == -1;
    }

    /**
     * Check if the stack is not empty
     */
    public function isNotEmpty(): bool
    {
        return $this->top != -1;
    }

    /**
     * @return null|array<int,mixed>
     */
    public function toArray()
    {
        if ($this->isNotEmpty()) {
            return $this->stack;
        }

        return null;
    }
}
