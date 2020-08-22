<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Folders
$folders = $api->folders()->get();

// Retrieve a Folder
$folder = $api->folder(1)->get();

// Create a Folder
$api->folders()->create([
    'name' => 'Amsterdam'
]);

// Update a Folder
$api->folder(1)->update([
    'parent_folder' => 3
]);

// Delete a Folder
$api->folder(1)->delete();