<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

use Devinson\Architect\Lists\LinkedNode as Node;

class LinkedList
{
    private null|LinkedNode $head;

    public function __construct()
    {
        $this->head = null;
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

            return $newNode;
        }

        return $this->head = $newNode;
    }

    /**
     * Remove the last element in the list
     */
    public function pop(): bool
    {
        if ($this->isNotEmpty()) {
            $lastNode = $this->getLastNode();
            $currentNode = $this->head;

            while ($currentNode->getNext() != $lastNode) {
                $currentNode = $currentNode->getNext();
            }

            $currentNode->setNext(null);
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
            $newNode->setNext($this->head);
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
            $newHead = $this->head->getNext();
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
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;
            $prevNode = null;

            while ($currentNode->getData() != $target && $currentNode->getNext()) {
                $prevNode = $currentNode;
                $currentNode = $currentNode->getNext();
            }

            if ($currentNode->getData() == $target) {
                $newNode = new Node($data);

                if ($prevNode) {
                    $prevNode->setNext($newNode);
                    $newNode->setNext($currentNode);

                    return $newNode;
                }

                $prevNode = $newNode;
                $prevNode->setNext($currentNode);
                $this->head = $prevNode;

                return $newNode;
            }
        }

        return null;
    }

    /**
     * Insert an element after the specific node
     */
    public function addAfter(mixed $data, mixed $target): ?Node
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;

            while ($currentNode->getData() != $target && $currentNode->getNext()) {
                $currentNode = $currentNode->getNext();
            }

            if ($currentNode->getData() == $target) {
                $newNode = new Node($data);

                $currentNode = $currentNode->getNext();
                $currentNode->setNext($newNode);
                $newNode->setNext($currentNode);
            }
        }

        return null;
    }

    public function find(mixed $target): ?Node
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                while ($currentNode->getData() != $target->getData() && $currentNode->getNext()) {
                    $currentNode = $currentNode->getNext();
                }
            } else {
                while ($currentNode->getData() != $target && $currentNode->getNext()) {
                    $currentNode = $currentNode->getNext();
                }
            }

            return $currentNode;
        }

        return null;
    }

    public function remove(mixed $target): bool
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->head;
            $prevNode = null;

            while ($currentNode->getData() != $target && $currentNode->getNext()) {
                $prevNode = $currentNode;
                $currentNode = $currentNode->getNext();
            }

            if ($currentNode->getData() == $target) {
                if ($prevNode) {
                    $prevNode->setNext($currentNode->getNext());
                    unset($currentNode);
                } else {
                    $this->head = $currentNode->getNext();
                    unset($currentNode);
                }

                return true;
            }

            return false;
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

    public function getFirstNode(): ?Node
    {
        return $this->head;
    }

    public function isEmpty(): bool
    {
        return $this->head == null;
    }

    public function isNotEmpty(): bool
    {
        return $this->head != null;
    }
}