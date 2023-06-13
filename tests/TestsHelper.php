<?php

/**
 * @param array $data [Optional] It can replace all, or just some, of the config data.
 *
 * @return array[] Returns an array with database connection configs.
 */
function getConnectionData(array $data = [])
{
    $config = [
        'driver' => DB_DRIVER,
        'host' => DB_HOST,
        'database' => DB_NAME,
        'user' => DB_USER,
        'pass' => DB_PASS,
    ];

    if (isset($data[0])) {
        $config[0] = array_merge($config[0], $data[0]);
        unset($data[0]);
    }

    return array_merge($config, $data);
}
