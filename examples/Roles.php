<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the Roles
$roles = $api->roles()->get();

// Retrieve a Role
$role = $api->role(1)->get();

// Create a Role
$api->roles()->create([
    'name' => 'Interns'
]);

// Update a Role
$api->role(1)->update([
    'description' => 'Limited access only.'
]);

// Delete a Role
$api->role(1)->delete();