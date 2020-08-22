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
    'title' => 'The Title!'
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
$revision = $api->itemRevision($ollection, $id, $offset)->get();

// Revert to a Given Revision
$api->itemRevert()->update($ollection, $id, $revision);
```

## Files

```php

// List the files.
$files = $api->files()->get();

// Retrieve a File
$file = $api->file($id)->get();

// Create a File
$api->files()->create([
    'data' => base64_encode(file_gets_content('./file.pdf'))
]);

// Update a File
$api->file(1)->update([
    'data' => base64_encode(file_gets_content('./file.pdf'))
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

## Activity

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

```

## Extensions

```php

```

## Fields

```php

```

## Folders

```php

```

## Mail

```php

```

## Permissions

```php

```

## Projects

```php

```

## Relations

```php

```

## Revisions

```php

```

## Roles

```php

```

## SCIM

```php

```

## Server

```php

```

## Settings

```php

```

## Users

```php

```

## Utilities

```php

```

## Extensions 

```php

```