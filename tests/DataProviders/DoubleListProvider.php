<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests\DataProviders;

use Devinson\Architect\Lists\DoubleList;

final class DoubleListProvider
{
    /**
     * @return array<int, array<int, DoubleList>>
     */
    public static function shortList()
    {
        $list = new DoubleList();

        for ($i = 0; $i < 3; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int, array<int, DoubleList>>
     */
    public  static function mediumList()
    {
        $list = new DoubleList();

        for ($i = 0; $i < 10; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }

    /**
     * @return array<int, array<int, DoubleList>>
     */
    public  static function longList()
    {
        $list = new DoubleList();

        for ($i = 0; $i < 50; $i++) {
            $list->push('node' . ($i + 1));
        }

        return [
            [$list]
        ];
    }
}
