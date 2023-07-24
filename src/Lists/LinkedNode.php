<?php

declare(strict_types=1);

namespace Devinson\Architect\Lists;

class LinkedNode
{
    private mixed $data;
    private null|LinkedNode $next;

    public function __construct(mixed $data)
    {
        $this->data = $data;
        $this->next = null;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setNext(mixed $next): void
    {
        $this->next = $next;
    }

    public function getNext(): null|LinkedNode
    {
        return $this->next;
    }
}
