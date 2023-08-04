<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

use Devinson\Architect\Lists\DoubleNode as Node;

class DoubleList
{
    /**
     * First node in the list
     */
    protected ?Node $head;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->head = null;

        if (!empty($data)) {
            foreach ($data as $item) {
                $this->push($item);
            }
        }
    }

    /**
     * Insert an element at the end of the list
     */
    public function push(mixed $data): Node
    {
        $newNode = new Node($data);

        $lastNode = $this->getLastNode();

        if ($lastNode) {
            $lastNode->setNext($newNode);
            $newNode->setPrev($lastNode);

            return $newNode;
        }

        return $this->head = $newNode;
    }

    /**
     * Remove the last element in the list
     */
    public function pop(): bool
    {
        $lastNode = $this->getLastNode();

        if ($lastNode) {
            $prevLastNode = $lastNode->getPrev();
            $prevLastNode->setNext(null);

            unset($lastNode);

            return true;
        }

        return false;
    }

    /**
     * Insert an element at the top of the list
     */
    public function shift(mixed $data): Node
    {
        $newNode = new Node($data);

        if ($this->isNotEmpty()) {
            $firstNode = $this->getFirstNode();
            $newNode->setNext($firstNode);
            $firstNode->setPrev($newNode);
            $this->head = $newNode;

            return $this->head;
        }

        $this->head = $newNode;

        return $this->head;
    }

    /**
     * Remove the first element in the list
     */
    public function unshift(): bool
    {
        if ($this->isNotEmpty()) {
            $newHead = $this->findAfter($this->head);
            $newHead->setPrev(null);
            $this->head = $newHead;

            return true;
        }

        return false;
    }

    /**
     * Insert an element before the specific node
     */
    public function addBefore(mixed $data, mixed $target): ?Node
    {
        $currentNode = $this->find($target);

        if ($currentNode) {
            $newNode = new Node($data);
            $prevCurrentNode = $currentNode->getPrev();

            $newNode->setNext($currentNode);
            $currentNode->setPrev($newNode);

            $prevCurrentNode && $prevCurrentNode->setNext($newNode);

            $newNode->setPrev($prevCurrentNode);

            return $newNode;
        }

        return null;
    }

    /**
     * Insert an element after the specific node
     */
    public function addAfter(mixed $data, mixed $target): ?Node
    {
        $currentNode = $this->find($target);

        if ($currentNode) {
            $newNode = new Node($data);
            $nextCurrentNode = $currentNode->getNext();

            $currentNode->setNext($newNode);
            $newNode->setPrev($currentNode);

            $nextCurrentNode && $nextCurrentNode->setPrev($newNode);

            $newNode->setNext($nextCurrentNode);

            return $newNode;
        }

        return null;
    }

    /**
     * Find an elemento into the list
     */
    public function find(mixed $target): ?Node
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            while ($currentNode->getData() != $target && $currentNode->getNext()) {
                $currentNode = $currentNode->getNext();
            }

            return $currentNode;
        }

        return null;
    }

    /**
     * Find the element before the target
     */
    public function findBefore(mixed $target): ?Node
    {
        return $this->find($target)->getPrev();
    }

    /**
     * Find the element after the target
     */
    public function findAfter(mixed $target): ?Node
    {
        return $this->find($target)->getNext();
    }

    /**
     * Remove a specific element into the list
     */
    public function remove(mixed $target): bool
    {
        $currentNode = $this->find($target);

        if ($currentNode) {
            $prevCurrentNode = $currentNode->getPrev();
            $nextCurrentNode = $currentNode->getNext();

            $prevCurrentNode && $prevCurrentNode->setNext($nextCurrentNode);
            $nextCurrentNode && $nextCurrentNode->setPrev($prevCurrentNode);

            unset($currentNode);

            return true;
        }

        return false;
    }

    /**
     * @return null|array<int, mixed>
     */
    public function toArray()
    {
        if ($this->isNotEmpty()) {
            $array = [];
            $currentNode = $this->head;

            while ($currentNode) {
                $array[] = $currentNode->getData();

                $currentNode = $currentNode->getNext();
            }

            return $array;
        }

        return null;
    }

    /**
     * Return the last element in the list
     */
    public function getLastNode(): ?Node
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;

            while ($currentNode->getNext()) {
                $currentNode = $currentNode->getNext();
            }

            return $currentNode;
        }

        return null;
    }

    /**
     * Return the first element in the list
     */
    public function getFirstNode(): ?Node
    {
        return $this->head;
    }

    /**
     * Check if the list is empty
     */
    public function isEmpty(): bool
    {
        return $this->head == null;
    }

    /**
     * Check if the list is not empty
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }
}
