<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests\DataProviders;

use Devinson\Architect\Queues\Queue;

final class QueueProvider
{
    /**
     * @return array<int,array<int,Queue>>
     */
    public static function shortQueue()
    {
        $queue = new Queue();

        for ($i = 0; $i < 3; $i++) {
            $queue->enQueue('element' . ($i + 1));
        }

        return [
            [$queue]
        ];
    }

    /**
     * @return array<int,array<int,Queue>>
     */
    public static function mediumQueue()
    {
        $queue = new Queue();

        for ($i = 0; $i < 10; $i++) {
            $queue->enQueue('element' . ($i + 1));
        }

        return [
            [$queue]
        ];
    }
}
