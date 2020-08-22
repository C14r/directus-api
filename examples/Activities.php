<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List Activity Actions
$activities = $api->activities()->get();

// Retrieve an Activity Action
$activity = $api->activity(1)->get();

// Create a Comment
$api->comments()->create([
    'collection' => 'my_collection',
    'id' => 1,
    'comment' => 'The body of the comment.'
]);

// Update a Comment
$api->comment(1)->update([
    'comment' => 'The new body of the comment.'
]);

// Delete a Comment
$api->comment(1)->delete();