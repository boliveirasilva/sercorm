<?php

namespace SercTest\Features\Core;

use PHPUnit\Framework\TestCase;
use SercORM\Core\ConnectionDB;

require_once dirname(__DIR__) . '/../TestsHelper.php';

class ConnectionDBTest extends TestCase
{
    /** @test */
    public function it_should_end_application_when_connection_fails()
    {
        /* --------------------------------------------------------------------------------- *
         * It is not possible to correctly test a block of code that ends the application,   *
         * so this test mocks the closing method to guarantee that the process would work.   *
         * --------------------------------------------------------------------------------- */

        $connection_data = getConnectionData(['database' => 'wrong-database','pass' => 'wrong-pass']);

        // Mocking the connection class to test connection fail
        $conn = $this->getMockBuilder(ConnectionDB::class)
            ->setConstructorArgs(array($connection_data))
            ->setMethods(['failedConnection'])
            ->getMock();

        $conn->expects($this->once())
            ->method("failedConnection")
            ->willThrowException(new \Exception('Deu ruim...', 171));

        // Prepares the test for the expected exception.
        self::expectExceptionCode(171);

        // Get the new ADO Connection
        $conn->getNewConnection();
    }
}
