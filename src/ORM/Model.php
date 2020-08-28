<?php

declare(strict_types=1);

namespace C14r\Directus\ORM;

abstract class Model extends Connection
{
    protected static function newInstance(object $response): self
    {
        if (static::api()->isError($response)) {
            return null;
        }

        return new static((array) $response->data);
    }

    protected static function newCollection(object $response): Collection
    {
        if (static::api()->isError($response)) {
            return new Collection();
        }

        array_walk($response->data, function (&$a) {
            $a = new static((array) $a);
        });

        return new Collection($response->data);
    }
}