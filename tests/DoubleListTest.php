<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\DoubleList;
use Devinson\Architect\Lists\DoubleNode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DoubleListTest extends TestCase
{
    public const SHORT_DOUBLE_LIST_LENGTH = 10;
    public const MEDIUM_DOUBLE_LIST_LENGTH = 25;
    public const LONG_DOUBLE_LIST_LENGTH = 50;

    final public function testDoubleListConstructor(): void
    {
        $arrayList = ['item1', 'item2', 'item3'];

        $list = new DoubleList();

        $this->assertSame(true, $list->isEmpty());

        $list = new DoubleList($arrayList);

        $this->assertSame(false, $list->isEmpty());
        $this->assertSame(3, $list->getLength());
        $this->assertSame($arrayList, $list->toArray());
    }

    /**
     * @param DoubleList<string> $list
     */
    #[DataProvider('doubleListProvider')]
    public function testPushElement(DoubleList $list): void
    {
        $listLength = $list->getLength();

        $list->push('newNode');
        $this->assertSame('newNode', $list->findLast());
        $this->assertSame(($listLength + 1), $list->getLength());

        $list = new DoubleList();

        $this->assertSame(0, $list->getLength());

        $list->push('newNode');

        $this->assertSame(1, $list->getLength());
        $this->assertSame('newNode', $list->findFirst());
        $this->assertSame('newNode', $list->findLast());
    }

    /**
     * @param DoubleList<string> $list
     */
    #[DataProvider('doubleListProvider')]
    public function testPopElement(DoubleList $list): void
    {
        $listLength = $list->getLength();
        $oldLastNode = $list->findLast();
        $prevOldLastNode = $list->getLastNode()?->getPrev();

        $poppedNode = $list->pop();

        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertSame($poppedNode, $oldLastNode);
        $this->assertSame($prevOldLastNode, $list->findLast());

        $listLength = $list->getLength();

        for ($i = 0; $i < $listLength; $i++) {
            $list->pop();
        }

        $this->assertSame(0, $list->getLength());
        $this->assertSame(true, $list->isEmpty());
    }

    /**
     * @param DoubleList<string> $list
     */
    #[DataProvider('doubleListProvider')]
    public function testShiftElement(DoubleList $list): void
    {
        $listLength = $list->getLength();
        $oldFirstNode = $list->findFirst();

        $list->shift('newNode');

        $this->assertSame(($listLength + 1), $list->getLength());
        $this->assertSame('newNode', $list->findFirst());
        $this->assertSame($oldFirstNode, $list->getFirstNode()?->getNext());

        $list = new DoubleList();
        $list->shift('newNode');

        $this->assertSame(1, $list->getLength());
        $this->assertSame('newNode', $list->findFirst());
    }

    /**
     * @param DoubleList<string> $list
     */
    #[DataProvider('doubleListProvider')]
    public function testUnshiftElement(DoubleList $list): void
    {
        $listLength = $list->getLength();
        $oldFirstNode = $list->findFirst();
        $nextOldFirstNode = $list->getFirstNode()?->getNext();

        $unshiftedNode = $list->unshift();

        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertSame($oldFirstNode, $unshiftedNode);
        $this->assertSame($nextOldFirstNode, $list->findFirst());

        $listLength = $list->getLength();

        for ($i = 0; $i < $listLength; $i++) {
            $list->unshift();
        }

        $this->assertSame(0, $list->getLength());
        $this->assertSame(true, $list->isEmpty());
    }

    public function testAddBeforeAnElement(): void
    {
        $list = new DoubleList(['item1', 'item2', 'item3', 'item4', 'item5']);

        $listLength = $list->getLength();

        $list->addBefore('newNode', 'item3');

        $this->assertSame(($listLength + 1), $list->getLength());
        $this->assertSame('item3', $list->findAfter('newNode'));
        $this->assertSame('item2', $list->findBefore('newNode'));
        $this->assertSame('newNode', $list->findAfter('item2'));
        $this->assertSame('newNode', $list->findBefore('item3'));

        /** @var DoubleNode<string> */
        $oldFirstNode = $list->findFirst();

        $list->addBefore('otherNewNode', 'item1');

        $this->assertSame('otherNewNode', $list->findFirst());
        $this->assertSame($oldFirstNode, $list->findAfter('otherNewNode'));
        $this->assertSame(null, $list->findBefore('otherNewNode'));
        $this->assertSame('otherNewNode', $list->findBefore($oldFirstNode));
    }

    /**
     * @param DoubleList<string> $list
     */
    #[DataProvider('doubleListProvider')]
    public function testRemoveAnItem(DoubleList $list): void
    {
        $listLength = $list->getLength();

        /** @var DoubleNode<string> */
        $prevRemovedNode = $list->findBefore('node3');

        /** @var DoubleNode<string> */
        $nexRemovedNode = $list->findAfter('node3');

        /** @var DoubleNode<string> */
        $nodeRemoved = $list->remove('node3');

        $this->assertSame(($listLength - 1), $list->getLength());
        $this->assertSame(null, $list->find($nodeRemoved));
        $this->assertSame($nexRemovedNode, $list->findAfter($prevRemovedNode));
        $this->assertSame($prevRemovedNode, $list->findBefore($nexRemovedNode));
    }

    /**
     * @return array<string,DoubleList<string>[]>
     */
    public static function doubleListProvider(): array
    {
        for ($i = 0; $i < static::SHORT_DOUBLE_LIST_LENGTH; $i++) {
            $shortList[] = 'node' . ($i + 1);
        }

        for ($i = 0; $i < static::MEDIUM_DOUBLE_LIST_LENGTH; $i++) {
            $mediumList[] = 'node' . ($i + 1);
        }

        for ($i = 0; $i < static::LONG_DOUBLE_LIST_LENGTH; $i++) {
            $longList[] = 'node' . ($i + 1);
        }

        return [
            'shortList' => [new DoubleList($shortList)],
            'mediumList' => [new DoubleList($mediumList)],
            'longList' => [new DoubleList($longList)],
        ];
    }
}
