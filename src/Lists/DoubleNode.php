<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

class DoubleNode
{
    /**
     * Value stored in the node
     */
    protected mixed $data;

    /**
     * Next node pointed to
     */
    protected ?DoubleNode $next;

    /**
     * Previous node pointed to
     */
    protected ?DoubleNode $prev;

    public function __construct(mixed $data)
    {
        $this->data = $data;
        $this->next = null;
        $this->prev = null;
    }

    /**
     * Sets the value contained in the node
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * Returns the values stored in the node
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Sets the next node to point to
     */
    public function setNext(mixed $next): void
    {
        $this->next = $next;
    }

    /**
     * Return the next node pointed to
     */
    public function getNext(): ?DoubleNode
    {
        return $this->next;
    }

    /**
     * Sets the previous node to point to
     */
    public function setPrev(mixed $prev): void
    {
        $this->prev = $prev;
    }

    /**
     * Return the previous node pointed to
     */
    public function getPrev(): ?DoubleNode
    {
        return $this->prev;
    }
}
