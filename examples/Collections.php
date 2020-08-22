<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List Collections
$collections = $api->collections()->get();

// Retrieve a Collection
$collection = $api->collection('my_collection')->get();

// Create a Collection
$api->collections()->create([
    'collection' => 'my_collection',
    'fields' => [
        [
            'field' => 'id',
            'type' => 'integer',
            'datatype' => 'int',
            'length' => 11,
            'interface' => 'numeric',
            'primary_key' => true
        ]
    ]
]);

// Update a Collection
$collection = $api->collection('my_collection')->update([
    'note' => 'This is my first collection'
]);

// Delete a Collection
$collection = $api->collection('my_collection')->delete();