# Directus

## Installing

The recommended way to install Directus-API is through
[Composer](https://getcomposer.org/).

```bash
composer require c14r/directus-api
```

# Usage

## Creating an API-instance

```php
use C14r\Directus\API;

$api = new API('http://example.com/api/', 'v1'); // base Url and project
```

## Error handling

```php
$items = $api->items($collection)->get();

if($api->isError($items)) {
    // The request failed.
}
```

## Authentification 

```php
// Retrieve a Temporary Access Token
$api->authenticate('username', '********');

// Using Static token
$api->token('ThIs_Is_ThE_tOkEn');
```

## Items

```php
// List the Items
$articles = $api->items($collection)->get();

// Retrieve an Item
$article = $api->item($collection, $id)->get();

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
$fields = $api->allFields()->get();

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
$api->projectDelete()->delete(); // <-- nasty :-( 
```

## Relations

```php
// Implemented but not yet documented.
```

## Revisions

```php
// Implemented but not yet documented.
```

## Roles

```php
// Implemented but not yet documented.
```

## SCIM

```php
// Implemented but not yet documented.
```

## Server

```php
// Implemented but not yet documented.
```

## Settings

```php
// Implemented but not yet documented.
```

## Users

```php
// Implemented but not yet documented.
```

## Utilities

```php
// Implemented but not yet documented.
```

## Custom 

```php
// Implemented but not yet documented.
```