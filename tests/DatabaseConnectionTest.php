<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use MamcoSy\Database\DatabaseConnection;
use MamcoSy\Database\Interfaces\DatabaseConnectionInterface;

class DatabaseConnectionTest extends TestCase
{
    public function getCredentials()
    {
        return Yaml::parseFile( __DIR__ . '/config/database/drivers.yml' );
    }

    /**
     * @param string $driver
     */
    public function getConnection( string $driver )
    {
        return new DatabaseConnection( $this->getCredentials()[$driver] );
    }

    public function testNewMysqlDatabaseConnection()
    {
        $database = $this->getConnection( 'mysql' );

        $this->assertInstanceOf(
            DatabaseConnectionInterface::class,
            $database
        );

        $this->assertInstanceOf( PDO::class, $database->open( 'test' ) );
    }

    public function testNewSqliteDatabaseConnection()
    {
        $database = $this->getConnection( 'sqlite' );

        $this->assertInstanceOf(
            DatabaseConnectionInterface::class,
            $database
        );

        $this->assertInstanceOf( PDO::class, $database->open( 'test' ) );
    }
}
