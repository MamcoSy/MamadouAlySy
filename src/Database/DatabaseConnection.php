<?php

declare ( strict_types = 1 );

namespace MamcoSy\Database;

use PDO;
use PDOException;
use MamcoSy\Database\Exceptions\DatabaseConnectionException;
use MamcoSy\Database\Interfaces\DatabaseConnectionInterface;

class DatabaseConnection implements DatabaseConnectionInterface
{
    protected string $name;
    protected array $credentials;
    protected  ? PDO $pdoInstance;

    /**
     * @param array $credentials
     */
    public function __construct( array $credentials )
    {
        $this->credentials = $credentials;
        $this->pdoInstance = null;
    }

    /**
     * @inheritDoc
     */
    public function open( string $databaseName ) : PDO
    {

        if ( $this->is_closed() ) {
            try {
                $this->pdoInstance = new PDO(
                    str_replace(
                        '{dbname}',
                        $databaseName,
                        $this->credentials['dsn'] )
                    ,
                    $this->credentials['user'],
                    $this->credentials['password']
                );
            } catch ( PDOException $e ) {
                throw new DatabaseConnectionException(
                    $e->getMessage(),
                    (int) $e->getCode()
                );
            }

        }

        return $this->pdoInstance;
    }

    /**
     * Undocumented function
     * @return void
     */
    public function close(): void
    {
        $this->pdoInstance = null;
    }

    /**
     * Check if connection is closed
     * @return boolean
     */
    public function is_closed(): bool
    {
        return is_null( $this->pdoInstance );
    }

}
