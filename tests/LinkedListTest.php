<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\LinkedList;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LinkedListTest extends TestCase
{
    final public function test_push_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $list->push('node');
        $this->assertSame('node', $list->getLastNode()->getData());
    }

    #[DataProvider('shortList')]
    final public function test_push_element_in_not_empty_list(LinkedList $list): void
    {
        $list->push('new node');

        $this->assertSame('new node', $list->getLastNode()->getData());
    }

    #[DataProvider('shortList')]
    final public function test_pop_element(LinkedList $list): void
    {
        $this->assertSame('node3', $list->getLastNode()->getData());

        $list->pop();

        $this->assertSame('node2', $list->getLastNode()->getData());
        $this->assertSame(null, $list->getLastNode()->getNext());
    }

    #[DataProvider('mediumList')]
    final public function test_list_to_array(LinkedList $list): void
    {
        // print_r($list->toArray());
        $this->assertIsArray($list->toArray());
    }

    final public function test_shift_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $list->shift('node');
        $this->assertSame('node', $list->getFirstNode()->getData());
    }

    #[DataProvider('mediumList')]
    final public function test_shift_element_in_not_empty_list(LinkedList $list): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $newNode = $list->shift('new node');
        $listHead = $list->getFirstNode();
        $this->assertSame($listHead, $newNode);
    }

    final public function test_unshift_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $this->assertSame(false, $list->unshift());
    }

    #[DataProvider('mediumList')]
    final public function test_unshift_element_in_not_empty_list(LinkedList $list): void
    {
        $list->unshift();

        $this->assertSame('node2', $list->getFirstNode()->getData());
    }

    #[DataProvider('mediumList')]
    final public function test_add_before(LinkedList $list): void
    {
        $addedNode = $list->addBefore('new node', 'node5');

        $this->assertSame($addedNode, $list->find('new node'));
    }

    #[DataProvider('longList')]
    final public function test_find_an_element(LinkedList $list): void
    {
        $this->assertSame('node3', $list->find('node3')->getData());
        $this->assertNotSame('node3', $list->find('node5')->getData());
    }

    #[DataProvider('mediumList')]
    final public function test_remove_method(LinkedList $list): void
    {
        $this->assertSame(true, $list->remove('node5'));
    }

    final public function test_construct(): void
    {
        $data = ['node1', 'node2', 'node3'];

        $list = new LinkedList($data);

        $this->assertSame($data, $list->toArray());
    }

    /**
     * @return array<int, array<int, LinkedList>>
     */
    public static function shortList()
    {
        $list = new LinkedList();

        for ($i = 0; $i < 3; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int, array<int, LinkedList>>
     */
    public  static function mediumList()
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int, array<int, LinkedList>>
     */
    public  static function longList()
    {
        $list = new LinkedList();

        for ($i = 0; $i < 50; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }
}
