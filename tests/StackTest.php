<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Stacks\Stack;
use Devinson\Architect\Tests\DataProviders\StackProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

final class StackTest extends TestCase
{
    public const SMALL_STACK_SIZE = 10;
    public const MEDIUM_STACK_SIZE = 25;
    public const LARGE_STACK_SIZE = 50;

    final public function testStackTestConstructor(): void
    {
        $arrayStack = ['a', 'b', 'c', 'd', 'e'];

        $stack = new Stack($arrayStack);

        $this->assertSame($arrayStack, $stack->toArray());
    }

    final public function testStackPush(): void
    {
        /** @var Stack<string> */
        $stack = new Stack();

        $stack->push('a');

        $this->assertSame('a', $stack->toArray()[0]);

        /** @var Stack<int> */
        $stack = new Stack();

        for ($i = 1; $i <= 10; $i++) {
            $stack->push($i);
        }

        $this->assertSame(10, $stack->getSize());
        $this->assertSame(10, $stack->getTop());
    }

    /**
     * @param Stack<string> $stack
     */
    #[DataProvider('stackProvider')]
    final public function testStackPop($stack): void
    {
        $oldTop = $stack->getTop();
        $oldSize = $stack->getSize();

        $poppedElement = $stack->pop();

        $this->assertSame($oldTop, $poppedElement);
        $this->assertSame(($oldSize - 1), $stack->getSize());

        foreach ($stack->toArray() as $element) {
            $stack->pop();
        }

        $this->assertSame(0, $stack->getSize());
        $this->assertSame(null, $stack->getTop());
    }

    /**
     * @return array<string,Stack<string>[]>
     */
    public  static function stackProvider()
    {
        for ($i = 0; $i < static::SMALL_STACK_SIZE; $i++) {
            $smallStack[] = 'element' . ($i + 1);
        }

        for ($i = 0; $i < static::MEDIUM_STACK_SIZE; $i++) {
            $mediumStack[] = 'element' . ($i + 1);
        }

        for ($i = 0; $i < static::LARGE_STACK_SIZE; $i++) {
            $largeStack[] = 'element' . ($i + 1);
        }

        return [
            'smallStack' => [new Stack($smallStack)],
            'mediumStack' => [new Stack($mediumStack)],
            'largeStack' => [new Stack($largeStack)]
        ];
    }
}
