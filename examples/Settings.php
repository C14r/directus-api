<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Settings
$settings = $api->settings()->get();

// Retrieve a Setting
$setting = $api->setting('my_custom_setting')->get();

// Create a Setting
$api->settings()->create([
    'key' => 'my_custom_setting',
    // 'value' => 12
]);

// Update a Setting
$api->setting('my_custom_setting')->update([
    'value' => 15
]);

//  Delete a Setting
$api->setting('my_custom_setting')->delete();