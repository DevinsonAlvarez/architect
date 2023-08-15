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
     */
    public function push($data): void
    {
        $newNode = new Node($data);

        if ($lastNode = $this->getLastNode()) {
            $lastNode->setNext($newNode);
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
        if (!$this->head) {
            return null;
        }

        if ($this->head->getNext()) {
            $lastNode = $this->getLastNode();
            $currentNode = $this->head;

            while ($currentNode->getNextNode() !== $lastNode) {
                $currentNode = $currentNode->getNextNode();
            }

            $currentNode->setNext(null);

            $poppedNode = $lastNode->getData();
            unset($lastNode);

            return $poppedNode;
        } else {
            $poppedNode = $this->head->getData();
            $this->head = null;

            return $poppedNode;
        }
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
            $newNode->setNext($this->head);
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
            $newHead = $this->head->getNextNode();

            $this->head = $newHead;

            return $oldHead;
        }

        return null;
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
        if ($this->head && $currentNode = $this->getNode($target)) {
            $prevNode = $this->getNodeBefore($currentNode);

            $newNode = new Node($data);

            if ($prevNode) {
                $prevNode->setNext($newNode);
                $newNode->setNext($currentNode);

                return $newNode;
            }

            $newNode->setNext($currentNode);
            $this->head = $newNode;

            return $this->head;
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
        if ($this->head) {
            $currentNode = $this->getNode($target);

            if ($currentNode) {
                $newNode = new Node($data);

                $newNode->setNext($currentNode->getNextNode());
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

            while ($currentNode->getData() !== $target && $nextNode = $currentNode->getNextNode()) {
                $currentNode = $nextNode;
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
        if ($this->head) {
            $currentNode = $this->head;

            if ($target instanceof Node) {
                $target = $target->getData();
            }

            if ($this->head->getData() === $target) {
                return null;
            }

            $prevNode = null;

            while ($currentNode->getData() !== $target && $currentNode->getNextNode()) {
                $prevNode = $currentNode;
                $currentNode = $currentNode->getNextNode();
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
        return $this->getNode($target)?->getNext();
    }

    /**
     * Return the last element in the list
     *
     * @return null|TNode
     */
    public function findLast()
    {
        if ($this->head) {
            $currentNode = $this->head;

            while ($currentNode->getNextNode()) {
                $currentNode = $currentNode->getNextNode();
            }

            return $currentNode->getData();
        }

        return null;
    }

    /**
     * Return the first element in the list
     *
     * @return null|TNode
     */
    public function findFirst()
    {
        if ($this->head) {
            return $this->head->getData();
        }

        return null;
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

            while ($currentNode->getData() !== $target && $nextNode = $currentNode->getNextNode()) {
                $currentNode = $nextNode;
            }

            if ($currentNode->getData() === $target) {
                return $currentNode;
            }
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

            while ($currentNode->getData() !== $target && $currentNode->getNextNode()) {
                $prevNode = $currentNode;
                $currentNode = $currentNode->getNextNode();
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
        return $this->getNode($target)?->getNextNode();
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
     * Remove a specific element into the list
     *
     * @param TNode|Node<TNode> $target
     */
    public function remove($target): bool
    {
        if ($this->head) {

            if ($targetNode = $this->getNode($target)) {
                $prevNode = $this->getNodeBefore($targetNode);

                if ($prevNode) {
                    $prevNode->setNext($targetNode->getNextNode());

                    unset($targetNode);
                } else {
                    $this->head = $this->head->getNextNode();
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

    /**
     * Returns the number of elements in the list or null if it is empty
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
