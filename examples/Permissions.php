<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Permissions
$permissions = $api->permissions()->get();

// Retrieve a Permission
$permission = $api->permission(1)->get();

// List the Current User's Permissions
$permissions = $api->myPermissions()->get();

// List the Current User's Permissions for Given Collection
$permission = $api->myPermission('my_collection')->get();

// Create a Permission
$api->permissions()->create([
    'collection' => 'my_collection',
    'role' => 3,
    'read' => 'mine',
    'read_field_blacklist' => ['featured_image']
]);

// Update a Permission
$api->permission(1)->update([
    'read' => 'full'
]);

// Delete a Permission
$api->permission(1)->delete();