<?php

declare(strict_types=1);

namespace Devinson\Architect\Stacks;

/**
 * @template T
 */
class Stack
{
    private int $top = -1;

    /**
     * @var array<int,T>
     */
    private $stack = [];

    /**
     * @param T[] $data
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
     * 
     * @param T $data
     */
    public function push($data): void
    {
        $this->stack[++$this->top] = $data;
    }

    /**
     * Remove the top stack element
     * 
     * @return T
     */
    public function pop()
    {
        if ($this->isNotEmpty()) {
            $poppedElement = array_pop($this->stack);
            $this->top -= 1;
            return $poppedElement;
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
    public function getSize(): int
    {
        return $this->top + 1;
    }

    /**
     * Return the top element in the list
     * 
     * @return null|T
     */
    public function getTop()
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
     * @return null|array<int,T>
     */
    public function toArray()
    {
        if ($this->isNotEmpty()) {
            return $this->stack;
        }

        return null;
    }
}
