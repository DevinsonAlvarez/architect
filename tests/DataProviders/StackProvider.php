<?php

declare(strict_types=1);

namespace Devinson\Architect\Tests\DataProviders;

use Devinson\Architect\Stacks\Stack;

final class StackProvider
{
    /**
     * @return array<int,array<int,Stack>>
     */
    public static function shortStack()
    {
        $data = [];

        for ($i = 0; $i < 5; $i++) {
            $data[] = 'element' . ($i + 1);
        }

        $stack = new Stack($data);

        return [
            [$stack]
        ];
    }
}
