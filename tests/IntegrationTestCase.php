<?php

namespace Tests;

abstract class IntegrationTestCase extends \Laravel\Lumen\Testing\TestCase
{
    public static $setupDatabase = true;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setupDatabase();
    }

    /**
     * Ensure the database is booted
     * and migrations are run.
     */
    public function setupDatabase()
    {
        $this->artisan('migrate');
    }
}
