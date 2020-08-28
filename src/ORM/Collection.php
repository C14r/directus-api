<?php

declare(strict_types=1);

namespace C14r\Directus\ORM;

class Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }
}
