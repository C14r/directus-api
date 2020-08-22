<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Items
$items = $api->items('my_collection')->get();

// Retrieve an Item
$item = $api->item('my_collection', 1)->get();

// Create an Item
$api->items('my_collection')->create([
    'title' => 'The Title!',
    'status' => 'draft'
]);

// Update an Item
$api->item('my_collection', 1)->update([
    'title' => 'The new Title!'
]);

// Delete an Item
$api->item('my_collection', 1)->delete();

// List Item Revisions
$revisions = $api->itemRevisions('my_collection', 1)->get();

// Retrieve an Item Revision
$revision = $api->itemRevision('my_collection', 1, $offset)->get();

// Revert to a Given Revision
$api->itemRevert('my_collection', 1, 5)->update();