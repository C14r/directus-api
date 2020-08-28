<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use C14r\Directus\API;
use C14r\Directus\Requests\Items;

final class ProjectsTest extends TestCase
{
    private API $api;

    public function __construct()
    {
        parent::__construct();

        $this->api = new API('http://api.example.com/', 'v1');
    }

    public function testProjectInformation(): void
    {
        $response = $this->api->project('v1')->test();

        $this->assertEquals('v1/?', $response->url);
    }

    public function testAllProjects(): void
    {
        $response = $this->api->projects()->test();

        $this->assertEquals('server/projects?', $response->url);
    }
}