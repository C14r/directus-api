<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

$api->mail()->create([
    'to' => [
        'user@example.com',
        'admin@example.com'
    ],
    'subject' => 'New Password',
    'body' => 'Hello <b>{{name}}</b>, this is your new password: {{password}}.',
    'type' => 'html',
    'data' => [
        'name' => 'John Doe',
        'password' => 'secret'
    ]
]);