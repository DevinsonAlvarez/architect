<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Stacks\Stack;
use Devinson\Architect\Tests\DataProviders\StackProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

final class StackTest extends TestCase
{
    final public function test_push_element_in_empty_stack(): void
    {
        $stack = new Stack();

        $this->assertSame(true, $stack->isEmpty());

        $stack->push('element1');

        $this->assertSame(false, $stack->isEmpty());
        $this->assertSame('element1', $stack->find(0));
    }

    #[DataProviderExternal(StackProvider::class, 'shortStack')]
    final public function test_push_element_in_not_empty_stack(Stack $stack): void
    {
        $stack->push('new element');

        $this->assertSame('new element', $stack->getTop());
    }

    #[DataProviderExternal(StackProvider::class, 'shortStack')]
    final public function test_pop_element_in_not_empty_stack(Stack $stack): void
    {
        $poppedElement = $stack->pop();

        $this->assertSame('element5', $poppedElement);
        $this->assertSame(4, $stack->getSize());
    }
}
