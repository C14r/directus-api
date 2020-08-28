<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Relations
$relations = $api->relations()->get();

// Retrieve a Relation
$relation = $api->relation(1)->get();

// Create a Relation
$api->relations()->create([
    'collection_many' => 'articles',
    'field_many' => 'author',
    'collection_one' => 'authors',
    'field_one' => 'books'
]);

// Update a Relation
$api->relation(1)->update([
    'field_one' => 'books'
]);

//  Delete a Relation
$api->relation(1)->delete();