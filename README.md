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

## Authentification 

```php
$api->authenticate('username', '********'); // Using Credentials

// or

$api->token('ThIs_Is_ThE_tOkEn'); // Using a Token
```

## Retrieving items

```php
// multiple
$articles = $api->items('articles')->get();

// or single
$article = $api->item('articles', 1)->get();
```