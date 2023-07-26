<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\DoubleList;
use Devinson\Architect\Tests\DataProviders\DoubleListProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

final class DoubleListTest extends TestCase
{
    final public function test_push_element_in_empty_list(): void
    {
        $list = new DoubleList();

        $list->push('node');

        $this->assertSame('node', $list->getFirstNode()->getData());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'shortList')]
    final public function test_push_element_in_not_empty_list(DoubleList $list): void
    {
        $list->push('new node');

        $this->assertSame('new node', $list->getLastNode()->getData());
        $this->assertSame(null, $list->getLastNode()->getNext());
        $this->assertSame('node3', $list->getLastNode()->getPrev()->getData());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'shortList')]
    final public function test_pop_element(DoubleList $list): void
    {
        $this->assertSame('node3', $list->getLastNode()->getData());

        $list->pop();

        $this->assertSame('node2', $list->getLastNode()->getData());
        $this->assertSame('node1', $list->getLastNode()->getPrev()->getData());
        $this->assertSame(null, $list->getLastNode()->getNext());
    }

    final public function test_shift_element_in_empty_list(): void
    {
        $list = new DoubleList();

        $list->shift('new node');

        $this->assertSame('new node', $list->getFirstNode()->getData());
        $this->assertSame(null, $list->getFirstNode()->getNext());
        $this->assertSame(null, $list->getFirstNode()->getPrev());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'shortList')]
    final public function test_shift_element_in_not_empty_list(DoubleList $list): void
    {
        $list->shift('new node');

        $this->assertSame('new node', $list->getFirstNode()->getData());
        $this->assertSame('node1', $list->getFirstNode()->getNext()->getData());
        $this->assertSame(null, $list->getFirstNode()->getPrev());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'shortList')]
    final public function test_unshift_element(DoubleList $list): void
    {
        $list->unshift('node1');

        $this->assertSame('node2', $list->getFirstNode()->getData());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'mediumList')]
    final public function test_add_before(DoubleList $list): void
    {
        $targetNode = $list->find('node3');

        $newNode = $list->addBefore('new node', $targetNode);

        $this->assertSame('node2', $newNode->getPrev()->getData());
        $this->assertSame('node3', $newNode->getNext()->getData());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'mediumList')]
    final public function test_add_after(DoubleList $list): void
    {
        $targetNode = $list->find('node5');

        $newNode = $list->addAfter('new node', $targetNode);

        $this->assertSame('node5', $newNode->getPrev()->getData());
        $this->assertSame('node6', $newNode->getNext()->getData());
    }

    #[DataProviderExternal(DoubleListProvider::class, 'mediumList')]
    final public function test_remove_element(DoubleList $list): void
    {
        $this->assertSame(true, $list->remove('node5'));
    }

    final public function test_construct(): void
    {
        $data = ['node1', 'node2', 'node3'];

        $list = new DoubleList($data);

        $this->assertSame($data, $list->toArray());
    }
}
