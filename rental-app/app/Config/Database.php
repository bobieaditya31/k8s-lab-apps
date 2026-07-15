<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Database Configuration
 *
 * @package Config
 */
class Database extends BaseConfig
{
    /**
     * The default database connection.
     */
    public $defaultGroup = 'default';

    /**
     * The default database connection will be called as $db.  If
     * you change the name here, then that will become the variable
     * name used in your model, and everywhere else the database
     * connection is used.
     */
    public $default = [
        'DSN'      => '',
        'hostname' => '172.26.107.25',
        'username' => 'admin',
        'password' => 'postgres',
        'database' => 'rental_kendaraan',
        'DBDriver' => 'Postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8',
        'DBCollat' => '',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'port'     => 5432,
        'foreignKeys' => true,
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     */
    public $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => '',
        'password' => '',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_',
        'pConnect' => false,
        'DBDebug'  => true,
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8',
        'DBCollat' => '',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'port'     => 3306,
        'foreignKeys' => true,
    ];

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't accidentally populate the live database with test data.
        if ($_ENV['CI_ENVIRONMENT'] === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
