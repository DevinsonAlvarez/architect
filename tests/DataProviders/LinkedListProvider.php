<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests\DataProviders;

use Devinson\Architect\Lists\LinkedList;

final class LinkedListProvider
{
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
    public static function mediumList()
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
    public static function longList()
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
