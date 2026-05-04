<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed essential roles and permissions for all tests
        $this->seed(\Database\Seeders\AdminUserSeeder::class);
    }
}
