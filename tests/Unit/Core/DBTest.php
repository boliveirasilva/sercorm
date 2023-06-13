<?php

namespace SercTest\Unit\Core;

use PHPUnit\Framework\TestCase;
use SercORM\Core\DB;

class DBTest extends TestCase
{
    /** @test */
    public function DB_class_must_implement_singleton_and_return_only_one_instance()
    {
        // $db_options = ['db_settings' => getConnectionData(),];

        $first = DB::getInstance(null, getConnectionData());
        $second = DB::getInstance();

        self::assertEquals($first, $second, "Não foi possível validar que DB tenha uma instância única!");
    }
}
