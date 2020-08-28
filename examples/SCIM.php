<?php

declare(strict_types=1);

use C14r\Directus\API;

require_once __DIR__ . '/../vendor/autoload.php';

$api = new API('http://example.com/', 'api');

//$api->authenticate('admin@example.com', 'password');
$api->token('ThIs_Is_ThE_tOkEn');

//  List SCIM Users
$users = $api->scimUsers()->get();

// Retrieve a SCIM User
$user = $api->scimUser($external_id)->get();

//  Create a SCIM User
$api->scimUsers()->create([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:User'
    ],
    'userName' => 'johndoe@example.com',
    'externalId' => 'johndoe-id',
    'name' => [
        'familyName' => 'Doe',
        'givenName' => 'John'
    ]
]);

// Update a SCIM User
$api->scimUser($external_id)->update([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:User'
    ],
    'name' => [
        'familyName' => 'Doe',
        'givenName' => 'Johnathan'
    ]
]);

// Delete a SCIM User
$api->scimUser($external_id)->delete();

// List the SCIM Groups
$groups = $api->scimGroups()->get();

//  Retrieve a SCIM Group
$group = $api->scimGroup(1)->get();

// Create a SCIM Group
$api->scimGroups()->create([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:Group'
    ],
    'displayName' => 'Editors',
    'externalId' => 'editors-id'
]);

//  Update a SCIM Group
$api->scimGroup(1)->update([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:Group'
    ],
    'displayName' => 'Writers'
]);

// Delete a SCIM Group
$api->scimGroup(1)->delete();