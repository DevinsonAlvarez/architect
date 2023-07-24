<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Lists\LinkedList;
use PHPUnit\Framework\TestCase;

final class LinkedListTest extends TestCase
{
    public function test_push_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $list->push('node');
        $this->assertSame('node', $list->getLastNode()->getData());
    }

    public function test_push_element_in_not_empty_list(): void
    {
        $list = new LinkedList();
        $list->push('node1');
        $list->push('node2');
        $list->push('node3');

        $list->push('new node');

        $this->assertSame('new node', $list->getLastNode()->getData());
    }

    public function test_pop_element(): void
    {
        $list = new LinkedList();
        $list->push('node1');
        $list->push('node2');
        $list->push('node3');

        $this->assertSame('node3', $list->getLastNode()->getData());

        $list->pop();

        $this->assertSame('node2', $list->getLastNode()->getData());
        $this->assertSame(null, $list->getLastNode()->getNext());
    }

    public function test_list_to_array(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        // print_r($list->toArray());
        $this->assertIsArray($list->toArray());
    }

    public function test_shift_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $list->shift('node');
        $this->assertSame('node', $list->getFirstNode()->getData());
    }

    public function test_shift_element_in_not_empty_list(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $newNode = $list->shift('new node');
        $listHead = $list->getFirstNode();
        $this->assertSame($listHead, $newNode);
    }

    public function test_unshift_element_in_empty_list(): void
    {
        $list = new LinkedList();

        $this->assertSame(false, $list->unshift());
    }

    public function test_unshift_element_in_not_empty_list(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $list->unshift();

        $this->assertSame('node2', $list->getFirstNode()->getData());
    }

    public function test_add_before(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $addedNode = $list->addBefore('new node', 'node5');

        $this->assertSame($addedNode, $list->find('new node'));
    }

    public function test_find_an_element(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $this->assertSame('node3', $list->find('node3')->getData());
        $this->assertNotSame('node3', $list->find('node5')->getData());
    }

    public function test_remove_method(): void
    {
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        $this->assertSame(true, $list->remove('node5'));
    }
}
