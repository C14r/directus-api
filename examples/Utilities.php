<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// Create a Hash
$hash = $api->hash('Directus')->create();

// Verify a Hashed String
$valid = $api->hashMatch('Directus', $hash)->create();

// Generate a Random String
$string = $api->randomString(32)->create();

// Generate a 2FA Secret
$secret = $api->secret()->get();