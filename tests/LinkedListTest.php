<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\LinkedList;
use Devinson\Architect\Tests\DataProviders\LinkedListProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

final class LinkedListTest extends TestCase
{
    final public function test_push_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $list->push('node');
        $this->assertSame('node', $list->getLastNode()->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'shortList')]
    final public function test_push_element_in_not_empty_list(LinkedList $list): void
    {
        $list->push('new node');

        $this->assertSame('new node', $list->getLastNode()->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'shortList')]
    final public function test_pop_element(LinkedList $list): void
    {
        $this->assertSame('node3', $list->getLastNode()->getData());

        $list->pop();

        $this->assertSame('node2', $list->getLastNode()->getData());
        $this->assertSame(null, $list->getLastNode()->getNext());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
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

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
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

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
    final public function test_unshift_element_in_not_empty_list(LinkedList $list): void
    {
        $list->unshift();

        $this->assertSame('node2', $list->getFirstNode()->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
    final public function test_add_before(LinkedList $list): void
    {
        $newNode = $list->addBefore('new node', 'node5');

        $this->assertSame('node5', $newNode->getNext()->getData());
        $this->assertSame('new node', $list->find('node4')->getNext()->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
    final public function test_add_after(LinkedList $list): void
    {
        $newNode = $list->addAfter('new node', 'node5');

        $this->assertSame('node6', $newNode->getNext()->getData());
        $this->assertSame('new node', $list->find('node5')->getNext()->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'longList')]
    final public function test_find_an_element(LinkedList $list): void
    {
        $this->assertSame('node3', $list->find('node3')->getData());
        $this->assertNotSame('node3', $list->find('node5')->getData());
    }

    #[DataProviderExternal(LinkedListProvider::class, 'mediumList')]
    final public function test_remove_element(LinkedList $list): void
    {
        $this->assertSame(true, $list->remove('node5'));
    }

    final public function test_construct(): void
    {
        $data = ['node1', 'node2', 'node3'];

        $list = new LinkedList($data);

        $this->assertSame($data, $list->toArray());
    }
}
