<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

// List Available Projects
$projects = $api->projects()->get();

// Retrieve Project Info
$project = $api->project('thumper')->get();

// Create a Project
$api->projects()->create([
    'project' => 'thumper',
    'super_admin_token' => 'very_secret_token',
    'db_name' => 'db',
    'db_user' => 'root',
    'db_password' => 'root',
    'user_email' => 'admin@example.com',
    'user_password' => 'password'
]);

// Delete a Project
$api->projects('thumper')->delete(); // <-- nasty :-( 