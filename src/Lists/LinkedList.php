<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

use Devinson\Architect\Lists\LinkedNode as Node;

/**
 * @template TNode
 */
class LinkedList
{
    /**
     * First node in the list
     *
     * @var null|Node<TNode> $head
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
     *
     * @return Node<TNode>
     */
    public function push($data): Node
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
        if ($this->head) {
            $lastNode = $this->getLastNode();
            $currentNode = $this->head;

            if ($lastNode) {
                while ($currentNode->getNext() !== $lastNode) {
                    if ($nextNode = $currentNode->getNext()) {
                        $currentNode = $nextNode;
                    }
                }

                $currentNode->setNext(null);
                unset($lastNode);

                return true;
            }
        }

        return false;
    }

    /**
     * Insert an element at the top of the list
     *
     * @param TNode $data
     * @return Node<TNode>
     */
    public function shift($data): Node
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
        if ($this->head) {
            if ($newHead = $this->head->getNext()) {
                $this->head = $newHead;

                return true;
            }
        }
        return false;
    }

    /**
     * Insert an element before the specific node
     *
     * @param TNode $data
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function addBefore($data, $target): ?Node
    {
        if ($this->isNotEmpty()) {
            if ($currentNode = $this->getNode($target)) {
                $prevNode = $this->getNodeBefore($currentNode);

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
     *
     * @param TNode $data
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function addAfter($data, $target): ?Node
    {
        if ($this->isNotEmpty()) {
            $currentNode = $this->getNode($target);

            if ($currentNode) {
                $newNode = new Node($data);

                $newNode->setNext($currentNode->getNext());
                $currentNode->setNext($newNode);

                return $newNode;
            }
        }

        return null;
    }

    /**
     * Find an element into the list
     *
     * @param TNode|Node<TNode> $target
     * @return null|TNode
     */
    public function find($target)
    {
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            while ($currentNode->getData() !== $target && $nextNode = $currentNode->getNext()) {
                $currentNode = $nextNode;
            }

            return $currentNode->getData();
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
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            if ($this->head->getData() === $target) {
                return null;
            }

            $prevNode = null;

            while ($currentNode->getData() !== $target && $currentNode = $currentNode->getNext()) {
                $prevNode = $currentNode;
            }

            if ($prevNode) {
                return $prevNode->getData();
            }
        }

        return null;
    }

    /**
     * Find the element after the target
     *
     * @param TNode|Node<TNode> $target
     * @return null|TNode
     */
    public function findAfter($target)
    {
        return $this->find($target)?->getNext()->getData();
    }

    /**
     * Returns a node from the list
     *
     * @param TNode|Node<TNode> $target
     * @return null|Node<TNode>
     */

    public function getNode($target): ?Node
    {
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            while ($currentNode->getData() !== $target && $nextNode = $currentNode->getNext()) {
                $currentNode = $nextNode;
            }

            return $currentNode;
        }

        return null;
    }

    /**
     * Return the node before the target
     *
     * @param TNode|Node<TNode> $target
     *
     * @return null|Node<TNode>
     */
    public function getNodeBefore($target): ?Node
    {
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            if ($this->head->getData() === $target) {
                return null;
            }

            $prevNode = null;

            while ($currentNode->getData() !== $target && $currentNode = $currentNode->getNext()) {
                $prevNode = $currentNode;
            }

            if ($prevNode) {
                return $prevNode;
            }
        }

        return null;
    }

    /**
     * Returns the node after the target
     *
     * @param TNode|Node<TNode> $target
     * @return null|Node<TNode>
     */
    public function getNodeAfter($target): ?Node
    {
        return $this->getNode($target)?->getNext();
    }

    /**
     * Remove a specific element into the list
     *
     * @param TNode|Node<TNode> $target
     */
    public function remove($target): bool
    {
        if ($this->head) {
            $currentNode = $this->head;
            $prevNode = null;

            while ($currentNode->getData() !== $target && $currentNode->getNext()) {
                $prevNode = $currentNode;
                $currentNode = $currentNode->getNext();
            }

            if ($currentNode !== null && $currentNode->getData() === $target) {
                if ($prevNode) {
                    $prevNode->setNext($currentNode->getNext());
                    unset($currentNode);
                } else {
                    $this->head = $currentNode->getNext();
                    unset($currentNode);
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @return null|array<int,TNode>
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
     *
     * @return null|Node<TNode>
     */
    public function getLastNode(): ?Node
    {
        if ($this->head) {
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
        return $this->head !== null;
    }
}
