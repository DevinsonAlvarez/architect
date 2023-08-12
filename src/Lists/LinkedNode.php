<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

/**
 * @template TValue
 */
class LinkedNode
{
    /**
     * Next node pointed to
     *
     * @var null|LinkedNode<TValue>
     */
    protected ?self $next = null;

    /**
     * @param TValue $data
     */
    public function __construct(protected $data)
    {
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
     *
     * @return TValue
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the next node to point to
     *
     * @param TValue $next
     */
    public function setNext($next): void
    {
        $this->next = new self($next);
    }

    /**
     * Return the next node pointed to
     *
     * @return null|LinkedNode<TValue>
     */
    public function getNext(): ?self
    {
        return $this->next;
    }
}
