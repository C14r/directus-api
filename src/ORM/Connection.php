<?php

declare(strict_types=1);

namespace C14r\Directus\ORM;

use C14r\Directus\API;

class Connection
{
    protected static $api;

    public static function api($baseUrlOrApi = null, ?string $project = null): API
    {
        if (!static::$api) {
            if ($baseUrlOrApi instanceof API) {
                static::$api = $baseUrlOrApi;
            }
            else {
                static::$api = new API($baseUrlOrApi, $project);
            }
        }

        return static::$api;
    }
}