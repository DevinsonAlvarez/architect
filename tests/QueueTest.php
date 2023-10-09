<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests;

use Devinson\Architect\Queues\Queue;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QueueTest extends TestCase
{
    public const SMALL_QUEUE_LENGTH = 10;
    public const MEDIUM_QUEUE_LENGTH = 25;
    public const LARGE_QUEUE_LENGTH = 50;

    final public function testQueueConstructor(): void
    {
        $queue = new Queue();
        $this->assertEmpty($queue->toArray());

        $queue = new Queue(['a', 'b', 'c']);
        $this->assertSame(['a', 'b', 'c'], $queue->toArray());
        $this->assertSame(3, $queue->getSize());
    }

    final public function testEnqueue(): void
    {
        $queue = new Queue();
        $this->assertSame(true, $queue->isEmpty());

        $queue->enqueue('a');
        $this->assertSame(false, $queue->isEmpty());

        $queue->enqueue('b');
        $queue->enqueue('c');

        $this->assertSame('a', $queue->peek());
        $this->assertSame('c', $queue->getRear());
        $this->assertSame(3, $queue->getSize());

        $this->assertSame(['a', 'b', 'c'], $queue->toArray());
    }

    /**
     * @param Queue<string> $queue
     */
    #[DataProvider('queueProvider')]
    final public function testDequeue(Queue $queue): void
    {
        $oldSize = $queue->getSize();
        $oldPeek = $queue->peek();

        $this->assertSame($oldPeek, $queue->dequeue());
        $this->assertSame(($oldSize - 1), $queue->getSize());
    }

    /**
     * @return array<string,Queue<string>[]>
     */
    public  static function queueProvider(): array
    {
        for ($i = 0; $i < static::SMALL_QUEUE_LENGTH; $i++) {
            $smallQueue[] = "item$i";
        }

        for ($i = 0; $i < static::MEDIUM_QUEUE_LENGTH; $i++) {
            $mediumQueue[] = "item$i";
        }

        for ($i = 0; $i < static::LARGE_QUEUE_LENGTH; $i++) {
            $largeQueue[] = "item$i";
        }

        return [
            'smallQueue' => [new Queue($smallQueue)],
            'mediumQueue' => [new Queue($mediumQueue)],
            'largeQueue' => [new Queue($largeQueue)],
        ];
    }
}
