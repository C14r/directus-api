<?php

declare(strict_types=1);

use C14r\Directus\ORM\Connection;
use C14r\Directus\ORM\Item;

require_once __DIR__ . '/../vendor/autoload.php';

class Page extends Item
{
}

Connection::api('http://example.com/', 'api'); // or Connection::api($api);
Connection::api()->token('ThIs_Is_ThE_tOkEn');

$pages = Page::find(1);

//print_r($pages);
