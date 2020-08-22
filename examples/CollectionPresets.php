<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Collection Presets
$presets = $api->presets()->get();

// Retrieve a Collection Preset
$preset = $api->preset(1)->get();

// Create a Collection Preset
$api->presets()->create([
    'collection' => 'my_collection',
    'title' => 'Title'
    // ...
]);

// Update a Collection Preset
$api->preset(1)->update([
    'collection' => 'my_collection',
    'title' => 'New Title'
]);

// Delete a Collection Preset
$api->preset(1)->delete();