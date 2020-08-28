<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List the users
$users = $api->users()->get();

// Retrieve a User
$user = $api->user(1)->get();

// Retrieve the Current User
$me = $api->me()->get();

// Create a User
$api->users()->create([
    'first_name' => 'Ben',
    'last_name' => 'Haynes',
    'email' => 'demo@example.com',
    'password' => 'd1r3ctu5',
    'role' => 3,
    'status' => 'active'
]);

// Update a User
$api->user(1)->update([
    'status' => 'suspended'
]);

// Delete a User
$api->user(1)->delete();

// Invite a New User
$api->invite('demo@example.com')->create();

//  Accept User Invite
$api->acceptUser($token)->post();

// Track the Last Used Page
$api->trackingPage(1, '/thumper/settings/')->update();

// List User Revisions
$revisions = $api->userRevisions(1)->get();

// Retrieve a User Revision
$revision = $api->userRevision(1, 5)->get();