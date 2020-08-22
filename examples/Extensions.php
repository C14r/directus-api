<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List Interfaces
$interfaces = $api->interfaces()->get();

// List Layouts
$layouts = $api->layouts()->get();

// List Modules
$modules = $api->modules()->get();