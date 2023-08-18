<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

use Devinson\Architect\Lists\DoubleNode as Node;

/**
 * @template TNode
 */
class DoubleList
{
    /**
     * First node in the list
     *
     * @var null|Node<TNode>
     */
    protected ?Node $head = null;

    /**
     * @param null|array<array-key,TNode> $data
     */
    public function __construct(?array $data = null)
    {
        if ($data) {
            foreach ($data as $item) {
                $this->push($item);
            }
        }
    }

    /**
     * Insert an element at the end of the list
     *
     * @param TNode $data
     */
    public function push($data): void
    {
        $newNode = new Node($data);

        $lastNode = $this->getLastNode();

        if ($lastNode) {
            $lastNode->setNext($newNode);
            $newNode->setPrev($lastNode);
        } else {
            $this->head = $newNode;
        }
    }

    /**
     * Remove the last element in the list
     *
     * @return null|TNode
     */
    public function pop()
    {
        if ($this->head && $lastNode = $this->getLastNode()) {
            $prevLastNode = $lastNode->getPrevNode();

            if ($prevLastNode) {
                $prevLastNode->setNext(null);

                $lastNodeData = $lastNode->getData();

                unset($lastNode);

                return $lastNodeData;
            }

            $oldHead = $this->head->getData();

            $this->head = null;

            return $oldHead;
        }

        return null;
    }

    /**
     * Insert an element at the top of the list
     *
     * @param TNode $data
     */
    public function shift($data): void
    {
        $newNode = new Node($data);

        if ($this->head) {
            $firstNode = $this->head;
            $newNode->setNext($firstNode);
            $firstNode->setPrev($newNode);
            $this->head = $newNode;
        }

        $this->head = $newNode;
    }

    /**
     * Remove the first element in the list
     *
     * @return null|TNode
     */
    public function unshift()
    {
        if ($this->head) {
            $oldHead = $this->head->getData();

            if ($nextFirst = $this->head->getNextNode()) {
                $nextFirst->setPrev(null);

                $this->head = $nextFirst;

                return $oldHead;
            } else {
                $this->head = null;
                return $oldHead;
            }
        }

        return null;
    }

    /**
     * Insert an element before the specific node
     *
     * @param TNode $data
     * @param TNode|Node<TNode> $target
     *
     * @return null|TNode
     */
    public function addBefore($data, $target)
    {
        if ($currentNode = $this->getNode($target)) {
            $newNode = new Node($data);

            if ($prevCurrentNode = $currentNode->getPrevNode()) {
                $newNode->setPrev($prevCurrentNode);
                $prevCurrentNode->setNext($newNode);

                $currentNode->setPrev($newNode);
                $newNode->setNext($currentNode);
            } else {
                $this->shift($newNode->getData());
            }

            return $newNode->getData();
        }

        return null;
    }

    /**
     * Insert an element after the specific node
     *
     * @param TNode $data
     * @param TNode|Node<TNode> $target
     * 
     * @return null|TNode
     */
    public function addAfter($data, $target)
    {
        if ($currentNode = $this->getNode($target)) {
            $newNode = new Node($data);

            if ($nextCurrentNode = $currentNode->getNextNode()) {
                $newNode->setNext($nextCurrentNode);
                $nextCurrentNode->setPrev($newNode);
            }

            $newNode->setPrev($currentNode);
            $currentNode->setNext($newNode);

            return $newNode->getData();
        }

        return null;
    }

    /**
     * Find an element into the list
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|TNode
     */
    public function find($target)
    {
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            while ($currentNode->getData() !== $target && $currentNode->getNextNode()) {
                $currentNode = $currentNode->getNextNode();
            }

            if ($currentNode->getData() === $target) {
                return $currentNode->getData();
            }
        }

        return null;
    }

    /**
     * Find the element before the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|TNode
     */
    public function findBefore($target)
    {
        return $this->getNode($target)?->getPrev();
    }

    /**
     * Find the element after the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|TNode
     */
    public function findAfter($target)
    {
        return $this->getNode($target)?->getNext();
    }

    /**
     * Find the list head
     *
     * @return null|TNode
     */
    public function findFirst()
    {
        return $this->head?->getData();
    }

    /**
     * Find the list rear
     *
     * @return null|TNode
     */
    public function findLast()
    {
        return $this->getLastNode()?->getData();
    }

    /**
     * Return the node that match with the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function getNode($target): ?Node
    {
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            while ($currentNode->getData() !== $target && $currentNode->getNextNode()) {
                $currentNode = $currentNode->getNextNode();
            }

            if ($currentNode->getData() === $target) {
                return $currentNode;
            }
        }

        return null;
    }

    /**
     * Find the element before the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function getNodeBefore($target): ?Node
    {
        return $this->getNode($target)?->getPrevNode();
    }

    /**
     * Find the element after the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function getNodeAfter($target): ?Node
    {
        return $this->getNode($target)?->getNextNode();
    }

    /**
     * Remove a specific element into the list
     *
     * @param TNode|Node<TNode> $target
     * 
     * @return null|TNode
     */
    public function remove($target)
    {
        /** @var null|Node<TNode> */
        $currentNode = $this->getNode($target);

        if ($currentNode) {
            $prevCurrentNode = $currentNode->getPrevNode();
            $nextCurrentNode = $currentNode->getNextNode();

            $prevCurrentNode && $prevCurrentNode->setNext($nextCurrentNode);
            $nextCurrentNode && $nextCurrentNode->setPrev($prevCurrentNode);

            $removedNode = $currentNode->getData();
            unset($currentNode);

            return $removedNode;
        }

        return null;
    }

    /**
     * @return null|array<int,TNode>
     */
    public function toArray()
    {
        if ($this->head) {
            $array = [];
            $currentNode = $this->head;

            while ($currentNode) {
                $array[] = $currentNode->getData();

                $currentNode = $currentNode->getNextNode();
            }


            return $array;
        }

        return null;
    }

    /**
     * Return the last element in the list
     *
     * @return null|Node<TNode>
     */
    public function getLastNode(): ?Node
    {
        if ($this->head) {
            $currentNode = $this->head;

            while ($currentNode->getNextNode()) {
                $currentNode = $currentNode->getNextNode();
            }

            return $currentNode;
        }

        return null;
    }

    /**
     * Return the first element in the list
     *
     * @return null|Node<TNode>
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
        return $this->head === null;
    }

    /**
     * Check if the list is not empty
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Return the number of elements in the list
     */
    public function getLength(): int
    {
        if ($this->head) {
            $currentNode = $this->head;
            $length = 0;

            while ($currentNode) {
                $length++;
                $currentNode = $currentNode->getNextNode();
            }

            return $length;
        }

        return 0;
    }
}
