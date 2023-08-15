<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\LinkedList;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LinkedListTest extends TestCase
{
    public const SHORT_LIST_LENGTH = 10;
    public const MEDIUM_LIST_LENGTH = 25;
    public const LONG_LIST_LENGTH = 50;

    final public function testLinkedListConstructor(): void
    {
        $arrayList = ['item1', 'item2', 'item3'];

        $list = new LinkedList();
        $this->assertSame(true, $list->isEmpty());

        $list = new LinkedList($arrayList);

        $this->assertSame(false, $list->isEmpty());
        $this->assertSame(3, $list->getLength());
        $this->assertSame($arrayList, $list->toArray());
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testFindAnElement(LinkedList $list): void
    {
        if ($list->getLength() === static::SHORT_LIST_LENGTH) {
            $this->assertSame('node1', $list->find('node1'));
            $this->assertSame('node4', $list->find('node4'));
            $this->assertSame('node10', $list->find('node10'));
        }

        if ($list->getLength() === static::MEDIUM_LIST_LENGTH) {
            $this->assertSame('node5', $list->find('node5'));
            $this->assertSame('node12', $list->find('node12'));
            $this->assertSame('node23', $list->find('node23'));
        }

        if ($list->getLength() === static::LONG_LIST_LENGTH) {
            $this->assertSame('node15', $list->find('node15'));
            $this->assertSame('node35', $list->find('node35'));
            $this->assertSame('node45', $list->find('node45'));
        }
    }

    final public function testFindBeforeAnElement(): void
    {
        $list = new LinkedList(['item1', 'item2', 'item3', 'item4', 'item5']);

        $this->assertSame('item2', $list->findBefore('item3'));
    }

    final public function testFindAfterAnElement(): void
    {
        $list = new LinkedList(['item1', 'item2', 'item3', 'item4', 'item5']);

        $this->assertSame('item4', $list->findAfter('item3'));
    }

    final public function testPushElementInEmptyList(): void
    {
        /** @var LinkedList<string> */
        $list = new LinkedList();

        $this->assertSame(0, $list->getLength());
        $this->assertSame(true, $list->isEmpty());

        $list->push('item1');

        $this->assertSame(1, $list->getLength());
        $this->assertSame(false, $list->isEmpty());
        $this->assertSame('item1', $list->findFirst());
        $this->assertSame('item1', $list->findLast());
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testPushElementInNotEmptyList(LinkedList $list): void
    {
        $lastNode = $list->findLast();
        $list->push('newNode');

        $this->assertNotSame($lastNode, $list->findLast());
        $this->assertSame('newNode', $list->findLast());
        $this->assertSame($lastNode, $list->findBefore('newNode'));
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testPopElement(LinkedList $list): void
    {
        $listLength = $list->getLength();
        $lastNode = $list->findLast();

        $poppedNode = $list->pop();

        $this->assertSame($lastNode, $poppedNode);
        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertNotSame($lastNode, $list->findLast());

        while ($poppedNode) {
            $poppedNode = $list->pop();
        }

        $this->assertSame(0, $list->getLength());
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testShiftElement(LinkedList $list): void
    {
        $listLength = $list->getLength();
        $firstNode = $list->findFirst();
        $newNode = 'newNode';

        $list->shift($newNode);

        $this->assertSame(($listLength + 1), $list->getLength());
        $this->assertSame($newNode, $list->findFirst());
        $this->assertSame($firstNode, $list->findAfter($newNode));
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testUnshiftElementInNotEmptyList(LinkedList $list): void
    {
        $listLength = $list->getLength();
        $firstNode = $list->findFirst();
        $secondNode = $list->getFirstNode()->getNext();

        $removedNode = $list->unshift();

        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertNotSame($firstNode, $list->getFirstNode());
        $this->assertSame($secondNode, $list->findFirst());
        $this->assertSame($removedNode, $firstNode);
    }

    /**
     * @param LinkedList<string> $list
     */
    public function testAddBeforeAnElement(): void
    {
        $listData = ['item1', 'item2', 'item3', 'item4', 'item5'];

        $list = new LinkedList($listData);

        $list->addBefore('newNode', 'item3');

        $this->assertSame('newNode', $list->find('newNode'));
        $this->assertSame('item3', $list->findAfter('newNode'));
        $this->assertSame('item2', $list->findBefore('newNode'));

        // Adding new element before list head
        $list = new LinkedList($listData);

        $list->addBefore('newNode', 'item1');

        $this->assertSame('newNode', $list->findFirst());
        $this->assertSame('item1', $list->findAfter('newNode'));
    }

    /**
     * @param LinkedList<string> $list
     */
    public function testAddAfterAnElement(): void
    {
        $listData = ['item1', 'item2', 'item3', 'item4', 'item5'];

        $list = new LinkedList($listData);

        $list->addAfter('newNode', 'item3');

        $this->assertSame('newNode', $list->find('newNode'));
        $this->assertSame('item4', $list->findAfter('newNode'));
        $this->assertSame('item3', $list->findBefore('newNode'));

        // Adding new element after list rear
        $list = new LinkedList($listData);

        $list->addAfter('newNode', 'item5');

        $this->assertSame('newNode', $list->findLast());
        $this->assertSame('item5', $list->findBefore('newNode'));
    }

    /**
     * @param LinkedList<string> $list
     */
    #[DataProvider('linkedListProvider')]
    final public function testRemoveAnItem(LinkedList $list): void
    {
        $listLength = $list->getLength();

        $this->assertSame(true, $list->remove('node5'));

        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertSame(null, $list->find('node5'));

        $this->assertSame(true, $list->remove('node1'));

        $this->assertSame(($listLength - 2), $list->getLength());
        $this->assertSame(null, $list->find('node1'));
        $this->assertSame('node2', $list->findFirst());

        $rear = $list->findLast();
        $beforeRear = $list->findBefore($rear);

        $this->assertSame(true, $list->remove($rear));
        $this->assertSame(null, $list->find($rear));
        $this->assertSame($beforeRear, $list->findLast());
    }

    /**
     * @return array<string,LinkedList<string>[]>
     */
    public static function linkedListProvider()
    {
        for ($i = 0; $i < static::SHORT_LIST_LENGTH; $i++) {
            $shortList[] = 'node' . ($i + 1);
        }

        for ($i = 0; $i < static::MEDIUM_LIST_LENGTH; $i++) {
            $mediumList[] = 'node' . ($i + 1);
        }

        for ($i = 0; $i < static::LONG_LIST_LENGTH; $i++) {
            $longList[] = 'node' . ($i + 1);
        }

        return [
            'shortList' => [new LinkedList($shortList)],
            'mediumList' => [new LinkedList($mediumList)],
            'longList' => [new LinkedList($longList)],
        ];
    }
}
