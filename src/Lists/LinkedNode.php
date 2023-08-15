<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

/**
 * @template TData
 */
class LinkedNode
{
    /**
     * Next node pointed to
     *
     * @var null|LinkedNode<TData>
     */
    protected ?LinkedNode $next = null;

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
     * @param null|TData|LinkedNode<TData> $next
     */
    public function setNext($next): void
    {
        if ($next === null) {
            $this->next = null;
        } else if ($next instanceof LinkedNode) {
            $this->next = $next;
        } else {
            $this->next = new LinkedNode($next);
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
     * @return null|LinkedNode<TData>
     */
    public function getNextNode(): ?LinkedNode
    {
        return $this->next;
    }
}
