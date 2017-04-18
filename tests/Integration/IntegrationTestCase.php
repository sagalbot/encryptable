<?php

namespace Tests\Integration;

use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;
use Tests\Framework\Migrate;

/**
 * Class IntegrationTestCase
 */
abstract class IntegrationTestCase extends TestCase
{

    /**
     * @var Illuminate\Database\Capsule\Manager
     */
    protected $db;


    /**
     * Create a DB connection, migrate.
     */
    public function setUp()
    {
        $this->db();
        ( new Migrate )->up();
    }


    /**
     * Reverse migrations, clear DB connection.
     */
    public function tearDown()
    {
        ( new Migrate )->down();
        $this->db = null;
    }


    /**
     * Maybe create a new DB instance, set up the
     * sqlite in-memory connection.
     * @return \Illuminate\Database\Capsule\Manager
     */
    protected function db()
    {
        if ($this->db) {
            return $this->db;
        }

        $this->db = new Capsule();

        $this->db->addConnection([
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);

        $this->db->bootEloquent();

        $this->db->setAsGlobal();

        return $this->db;
    }
}