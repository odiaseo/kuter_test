<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

include 'db_config.php';

return array(
   'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => "pgsql:dbname=$database;host=$host",
        'username' => $user,
        'password' => $password,
    ),
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => $host,
                    'port'     => $port,
                    'user'     => $user,
                    'password' => $password,
                    'dbname'   => $database,
                )
            )
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
