<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// Custom GET-Requests
$response = $api->custom('example')->get();

// Custom POST-Requests
$response = $api->custom('example')->post(); // or ->create()

// Custom PATCH-Requests
$response = $api->custom('example')->patch(); // or ->update()

// Custom DELETE-Requests
$response = $api->custom('example')->delete();

// Request with parameters
$response = $api->custom('example/:id', ['id' => 1])->get();