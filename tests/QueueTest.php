<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Queues\Queue;
use Devinson\Architect\Tests\DataProviders\QueueProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

final class QueueTest extends TestCase
{
    final public function test_enqueue_an_element_in_empty_queue(): void
    {
        $queue = new Queue();

        $this->assertSame(true, $queue->isEmpty());

        $elementPos = $queue->enQueue('element1');

        $this->assertSame(true, $queue->isNotEmpty());

        $this->assertSame('element1', $queue->find(0));
        $this->assertSame('element1', $queue->find($elementPos));
        $this->assertSame(1, $queue->getSize());
    }

    final public function test_enqueue_multiple_elements(): void
    {
        $queue = new Queue();

        $this->assertSame(true, $queue->isEmpty());

        for ($i = 0; $i < 5; $i++) {
            $queue->enQueue('element' . ($i + 1));
        }

        $this->assertSame(true, $queue->isNotEmpty());
        $this->assertSame(5, $queue->getSize());
        $this->assertSame('element1', $queue->getFront());
        $this->assertSame('element5', $queue->getRear());
    }

    #[DataProviderExternal(QueueProvider::class, 'shortQueue')]
    final public function test_dequeue(Queue $queue): void
    {
        $this->assertSame('element1', $queue->getFront());
        $this->assertSame(3, $queue->getSize());

        $queue->deQueue();

        $this->assertSame('element2', $queue->getFront());
        $this->assertSame(2, $queue->getSize());
    }

    #[DataProviderExternal(QueueProvider::class, 'mediumQueue')]
    final public function test_queue_to_array(Queue $queue): void
    {
        $array = $queue->toArray();

        foreach ($array as $key => $value) {
            $this->assertSame($queue->find($key), $array[$key]);
        }
    }
}
