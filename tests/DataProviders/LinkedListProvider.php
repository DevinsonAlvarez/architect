<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests\DataProviders;

use Devinson\Architect\Lists\LinkedList;

final class LinkedListProvider
{
    /**
     * @return array<int,array<int,LinkedList<string>>>
     */
    public static function shortList()
    {
        /** @var LinkedList<string> */
        $list = new LinkedList();

        for ($i = 0; $i < 3; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int,array<int,LinkedList<string>>>
     */
    public static function mediumList()
    {
        /** @var LinkedList<string> */
        $list = new LinkedList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int,array<int,LinkedList<string>>>
     */
    public static function longList()
    {
        /** @var LinkedList<string> */
        $list = new LinkedList();

        for ($i = 0; $i < 50; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }
}
