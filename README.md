# Directus API Wrapper for PHP

![packagist version](https://img.shields.io/packagist/v/c14r/directus-api)
![directus version](https://img.shields.io/badge/directus-v8.8.1-blue)

This package allows users to easily consume the REST API provided by the Directus Headless CMS system in any PHP app.

## Installing

The recommended way to install Directus-API is through
[Composer](https://getcomposer.org/).

```bash
composer require c14r/directus-api
```

## Table of Content

- [Directus API Wrapper for PHP](#directus-api-wrapper-for-php)
  - [Installing](#installing)
  - [Table of Content](#table-of-content)
- [Usage](#usage)
  - [Creating an API-instance](#creating-an-api-instance)
  - [Authentification](#authentification)
  - [Error handling](#error-handling)
  - [Items](#items)
  - [Files](#files)
  - [Assets (Thumbnails)](#assets-thumbnails)
  - [Activities](#activities)
  - [Collections](#collections)
  - [Collection Presets](#collection-presets)
  - [Extensions](#extensions)
  - [Fields](#fields)
  - [Folders](#folders)
  - [Mail](#mail)
  - [Permissions](#permissions)
  - [Projects](#projects)
  - [Relations](#relations)
  - [Revisions](#revisions)
  - [Roles](#roles)
  - [SCIM](#scim)
  - [Server](#server)
  - [Settings](#settings)
  - [Users](#users)
  - [Utilities](#utilities)
  - [Custom](#custom)

# Usage

## Creating an API-instance

```php
use C14r\Directus\API;

$api = new API('http://example.com/api/', 'v1'); // base Url and project
```

## Authentification 

```php
// Retrieve a Temporary Access Token
$api->authenticate('username', '********');

// Using Static token
$api->token('ThIs_Is_ThE_tOkEn');
```

## Error handling

```php
$items = $api->items($collection)->get();

if($api->isError($items)) {
    // The request failed.
}
```

## Items

```php
// List the Items
$items = $api->items($collection)->get();

// Retrieve an Item
$item = $api->item($collection, $id)->get();

// Create an Item
$api->items($collection)->create([
    'title' => 'The Title!',
    'status' => 'draft'
]);

// Update an Item
$api->item($collection, $id)->update([
    'title' => 'The new Title!'
]);

// Delete an Item
$api->item($collection, $id)->delete();

// List Item Revisions
$revisions = $api->itemRevisions($collection, $id)->get();

// Retrieve an Item Revision
$revision = $api->itemRevision($collection, $id, $offset)->get();

// Revert to a Given Revision
$api->itemRevert($collection, $id, $revision)->update();
```

## Files

```php

// List the files.
$files = $api->files()->get();

// Retrieve a File
$file = $api->file($id)->get();

// Create a File
$api->files()->create([
    'data' => base64_encode(file_get_contents('./file.pdf'))
]);

// Update a File
$api->file(1)->update([
    'data' => base64_encode(file_get_contents('./file.pdf'))
]);

// Delete a File
$api->file(1)->delete();

```

## Assets (Thumbnails)

```php

// Get an asset
$asset = $api->asset($private_hash)->get();

// or using key, w, h, f, q
$asset = $api->asset($private_hash)->queries([
    'key' => $key,
    'w' => 100,
    'h' => 100,
    'f' => 'crop',
    'q' => 80
])->get();

```

## Activities

```php
// List Activity Actions
$activities = $api->activities()->get();

// Retrieve an Activity Action
$activity = $api->activity($id)->get();

// Create a Comment
$api->comments()->create([
    'collection' => $collection,
    'id' => $id,
    'comment' => 'The body of the comment.'
]);

// Update a Comment
$api->comment($id)->update([
    'comment' => 'The new body of the comment.'
]);

// Delete a Comment
$api->comment($id)->delete();
```

## Collections

```php
// List Collections
$collections = $api->collections()->get();

// Retrieve a Collection
$collection = $api->collection($collection)->get();

// Create a Collection
$api->collections()->create([
    'collection' => 'my_collection',
    'fields' => [
        [
            'field' => 'id',
            'type' => 'integer',
            'datatype' => 'int',
            'length' => 11,
            'interface' => 'numeric',
            'primary_key' => true
        ]
    ]
]);

// Update a Collection
$collection = $api->collection($collection)->update([
    'note' => 'This is my first collection'
]);

// Delete a Collection
$collection = $api->collection($collection)->delete();
```

## Collection Presets

```php
// List the Collection Presets
$presets = $api->presets()->get();

// Retrieve a Collection Preset
$preset = $api->preset($id)->get();

// Create a Collection Preset
$api->presets()->create([
    'collection' => $collection,
    'title' => 'Title'
    // ...
]);

// Update a Collection Preset
$api->preset($id)->update([
    'collection' => $collection,
    'title' => 'New Title'
]);

// Delete a Collection Preset
$api->preset($id)->delete();
```

## Extensions

```php
// List Interfaces
$interfaces = $api->interfaces()->get();

// List Layouts
$layouts = $api->layouts()->get();

// List Modules
$modules = $api->modules()->get();
```

## Fields

```php
// List Fields
$fields = $api->fields()->get();

// List Fields in Collection
$fields = $api->fields($collection)->get();

// Retrieve a Field
$field = $api->field($collection, $field)->get();

// Create a Field
$api->fields($collection)->create([
    'field' => 'test',
    'type' => 'string',
    'datatype' => 'VARCHAR',
    'length' => 255,
    'interface' => 'text-input'
]);

// Update a Field
$api->field($collection, $field)->update([
    'note' => 'Enter the title here.'
]);

// Delete a Field
$api->field($collection, $field)->delete();
```

## Folders

```php
// List the Folders
$folders = $api->folders()->get();

// Retrieve a Folder
$folder = $api->folder($id)->get();

// Create a Folder
$api->folders()->create([
    'name' => 'Amsterdam'
]);

// Update a Folder
$api->folder($id)->update([
    'parent_folder' => 3
]);

// Delete a Folder
$api->folder($id)->delete();
```

## Mail

```php
// Send an Email
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
```

## Permissions

```php
// List the Permissions
$permissions = $api->permissions()->get();

// Retrieve a Permission
$permission = $api->permission($id)->get();

// List the Current User's Permissions
$permissions = $api->myPermissions()->get();

// List the Current User's Permissions for Given Collection
$permission = $api->myPermission($collection)->get();

// Create a Permission
$api->permissions()->create([
    'collection' => 'customers',
    'role' => 3,
    'read' => 'mine',
    'read_field_blacklist' => ['featured_image']
]);

// Update a Permission
$api->permission($id)->update([
    'read' => 'full'
]);

// Delete a Permission
$api->permission($id)->delete();
```

## Projects

```php
// List Available Projects
$projects = $api->projects()->get();

// Retrieve Project Info
$project = $api->project($project)->get();

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
$api->projects($project)->delete(); // There should be no s in 'projects', but unfortunately it has to be there because of the different endpoints :(
```

## Relations

```php
// List the Relations
$relations = $api->relations()->get();

// Retrieve a Relation
$relation = $api->relation($id)->get();

// Create a Relation
$api->relations()->create([
    'collection_many' => 'articles',
    'field_many' => 'author',
    'collection_one' => 'authors',
    'field_one' => 'books'
]);

// Update a Relation
$api->relation($id)->update([
    'field_one' => 'books'
]);

//  Delete a Relation
$api->relation($id)->delete();
```

## Revisions

```php
// List the Revisions
$revisions = $api->revisions()->get();

// Retrieve a Revision
$revision = $api->revision($id)->get();
```

## Roles

```php
// List the Roles
$roles = $api->roles()->get();

// Retrieve a Role
$role = $api->role($id)->get();

// Create a Role
$api->roles()->create([
    'name' => 'Interns'
]);

// Update a Role
$api->role($id)->update([
    'description' => 'Limited access only.'
]);

// Delete a Role
$api->role($id)->delete();
```

## SCIM

```php
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
$group = $api->scimGroup($id)->get();

// Create a SCIM Group
$api->scimGroups()->create([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:Group'
    ],
    'displayName' => 'Editors',
    'externalId' => 'editors-id'
]);

//  Update a SCIM Group
$api->scimGroup($id)->update([
    'schemas' => [
        'urn:ietf:params:scim:schemas:core:2.0:Group'
    ],
    'displayName' => 'Writers'
]);

// Delete a SCIM Group
$api->scimGroup($id)->delete();
```

## Server

```php
// Retrieve Server Info
$info = $api->info($super_admin_token)->get();

//  Ping the server
$pong = $api->ping()->get();
```

## Settings

```php
// List the Settings
$settings = $api->settings()->get();

// Retrieve a Setting
$setting = $api->setting($id)->get();

// Create a Setting
$api->settings()->create([
    'key' => 'my_custom_setting',
    // 'value' => 12
]);

// Update a Setting
$api->setting($id)->update([
    'value' => 15
]);

//  Delete a Setting
$api->setting($id)->delete();
```

## Users

```php
// List the users
$users = $api->users()->get();

// Retrieve a User
$user = $api->user($id)->get();

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
$api->user($id)->update([
    'status' => 'suspended'
]);

// Delete a User
$api->user($id)->delete();

// Invite a New User
$api->invite('demo@example.com')->create();

//  Accept User Invite
$api->acceptUser($token)->post();

// Track the Last Used Page
$api->trackingPage($id, '/thumper/settings/')->update();

// List User Revisions
$revisions = $api->userRevisions($id)->get();

// Retrieve a User Revision
$revision = $api->userRevision($id, $offset)->get();
```

## Utilities

```php
// Create a Hash
$hash = $api->hash('Directus')->create();

// Verify a Hashed String
$valid = $api->hashMatch('Directus', $hash)->create();

// Generate a Random String
$string = $api->randomString($length)->create();

// Generate a 2FA Secret
$secret = $api->secret()->get();
```

## Custom 

```php
// Custom GET-Requests
$response = $api->custom('example')->get();

// Custom POST-Requests
$response = $api->custom('example')->post(); // or ->create()

// Custom PATCH-Requests
$response = $api->custom('example')->patch(); // or ->update()

// Custom DELETE-Requests
$response = $api->custom('example')->delete();

// Request with parameters
$response = $api->custom('example/:id', ['id' => $id])->get();
```
