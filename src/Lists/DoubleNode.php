<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

/**
 * @template TData
 */
class DoubleNode
{
    /**
     * Next node pointed to
     *
     * @var null|DoubleNode<TData>
     */
    protected ?DoubleNode $next = null;

    /**
     * Previous node pointed to
     *
     * @var null|DoubleNode<TData>
     */
    protected ?DoubleNode $prev = null;

    /**
     * @param TData $data
     */
    public function __construct(protected $data)
    {
    }

    /**
     * Sets the value contained in the node
     *
     * @param TData $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * Returns the values stored in the node
     *
     * @return TData
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the next node to point to
     *
     * @param null|TData|DoubleNode<TData> $next
     */
    public function setNext($next): void
    {
        if ($next instanceof DoubleNode) {
            $this->next = $next;
        } elseif ($next === null) {
            $this->next = null;
        } else {
            $this->next = new DoubleNode($next);
        }
    }

    /**
     * Return the data that contains the next node
     *
     * @return null|TData
     */
    public function getNext()
    {
        return $this->next?->getData();
    }

    /**
     * Return the next node pointed to
     *
     * @return null|DoubleNode<TData>
     */
    public function getNextNode(): ?DoubleNode
    {
        return $this->next;
    }

    /**
     * Sets the previous node to point to
     *
     * @param null|TData|DoubleNode<TData> $prev
     */
    public function setPrev($prev): void
    {
        if ($prev instanceof DoubleNode) {
            $this->prev = $prev;
        } elseif ($prev === null) {
            $this->prev = null;
        } else {
            $this->prev = new DoubleNode($prev);
        }
    }

    /**
     * Return the data that contains the previous node
     *
     * @return null|TData
     */
    public function getPrev()
    {
        return $this->prev?->getData();
    }

    /**
     * Return the previous node pointed to
     *
     * @return null|DoubleNode<TData>
     */
    public function getPrevNode(): ?DoubleNode
    {
        return $this->prev;
    }
}
