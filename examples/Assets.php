<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// Get an asset
$asset = $api->asset($private_hash)->get();

// or using key, w, h, f, q
$asset = $api->asset($private_hash)->queries([
    'key' => $key,
    'w' => 100,
    'h' => 100,
    'f' => 'crop',
    'q' => 80
])->get();