<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List Fields
$fields = $api->fields()->get();

// List Fields in Collection
$fields = $api->fields('my_collection')->get();

// Retrieve a Field
$field = $api->field('my_collection', 'my_field')->get();

// Create a Field
$api->fields('my_collection')->create([
    'field' => 'test',
    'type' => 'string',
    'datatype' => 'VARCHAR',
    'length' => 255,
    'interface' => 'text-input'
]);

// Update a Field
$api->field('my_collection', 'my_field')->update([
    'note' => 'Enter the title here.'
]);

// Delete a Field
$api->field('my_collection', 'my_field')->delete();