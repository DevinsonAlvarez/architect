<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

class LinkedNode
{
    /**
     * Value stored in the node
     */
    protected mixed $data;

    /**
     * Next node pointed to
     */
    protected ?LinkedNode $next;

    public function __construct(mixed $data)
    {
        $this->data = $data;
        $this->next = null;
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
    public function getNext(): ?LinkedNode
    {
        return $this->next;
    }
}
