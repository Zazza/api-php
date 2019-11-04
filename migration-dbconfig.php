<?php
$config = parse_ini_file("app/config/config.ini", true);
return [
    'driver'    => 'pdo_mysql',
    'host'      => $config['db']['host'],
    'user'      => $config['db']['username'],
    'password'  => $config['db']['password'],
    'dbname'    => $config['db']['dbname'],
    'charset'   => 'UTF8'
];
