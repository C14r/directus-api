<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the files.
$files = $api->files()->get();

// Retrieve a File
$file = $api->file(1)->get();

// Create a File
$api->files()->create([
    'data' => base64_encode(file_get_contents('./file.pdf'))
]);

// Update a File
$api->file(1)->update([
    'data' => base64_encode(file_get_contents('./file.pdf'))
]);

// Delete a File
$api->file(1)->delete();