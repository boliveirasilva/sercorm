<?php

namespace SercORM\Core;

use ADOConnection;
use SercORM\Exception\SercORM_ConnectionException;

class DB
{
    /** @var self */
    private static $instance;

    /** @var ADOConnection */
    private $connection;

    /** @var array */
    private static $options = [];


    /**
     * @param ADOConnection $ado
     *
     * @return self
     */
    public static function getInstance(ADOConnection $ado = null, array $options = [])
    {
        if ($options) static::setOptions($options);

        if (! static::$instance || $ado != null) {
            static::$instance = new static($ado);
        }

        return static::$instance;
    }

    private function __construct(ADOConnection $ado = null)
    {
        if ($ado !== null) {
            $this->connection = $ado;
        } else {
            $this->connection = (new ConnectionDB(static::$options))->getNewConnection();
        }
    }

    /**
     * @param array $options
     * @return void
     */
    private static function setOptions(array $options)
    {
        self::$options = [
            'debug_connection' => ($options['debug_connection'] ?: false),
            'driver' => ($options['driver'] ?: null),
            'host' => ($options['host'] ?: null),
            'database' => (filter_var($options['database']) ?: null),
            'user' => (filter_var($options['user']) ?: null),
            'pass' => ($options['pass'] ?: null),
            'charset' => (filter_var($options['charset']) ?: null),
        ];
    }

    private function __clone() {}
}