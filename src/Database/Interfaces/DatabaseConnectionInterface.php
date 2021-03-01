<?php

declare ( strict_types = 1 );

namespace MamcoSy\Database\Interfaces;

use PDO;

interface DatabaseConnectionInterface
{
    /**
     * @param  string $databaseName
     * @return PDO
     */
    public function open( string $databaseName ): PDO;

    /**
     * Undocumented function
     * @return void
     */
    public function close(): void;

    /**
     * Check if connection is closed
     * @return boolean
     */
    public function is_closed(): bool;
}
