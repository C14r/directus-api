<?php

declare(strict_types=1);

namespace C14r\Directus\ORM;

class Field extends Model
{
    public static function find(string $collection, string $field): self
    {
        return static::newInstance(static::api()->field($collection, $field)->get());
    }

    public static function findAll(?string $collection = null): Collection
    {
        return static::newCollection(static::api()->fields($collection)->get());
    }
}