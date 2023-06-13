<?php

namespace SercTest\Unit\Core;

use PHPUnit\Framework\TestCase;
use SercORM\Core\ConnectionDB;

require_once dirname(__DIR__) . '/../TestsHelper.php';

class ConnectionDBTest extends TestCase
{
    /** @test */
    public function it_should_connect_to_configurated_database()
    {
        // Instantiate the connection class
        $conn = new ConnectionDB(getConnectionData());

        // Get the new ADO Connection
        $adoConnection = $conn->getNewConnection();

        self::assertTrue($adoConnection instanceof \ADOConnection);
    }

    /** @test */
    public function it_should_be_possible_to_activate_debug_on_the_connection()
    {
        // Instantiate the connection class
        $conn = new ConnectionDB(getConnectionData(['debug_connection' => true]));

        // Get the new ADO Connection
        $adoConnection = $conn->getNewConnection();

        self::assertTrue($adoConnection instanceof \ADOConnection);
        self::assertTrue($adoConnection->debug, "Could not activate the DEBUG MODE on ADOConnection");
    }
}
