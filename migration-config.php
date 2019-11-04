<?php
$config = parse_ini_file("app/config/config.ini", true);
return [
    'name' => 'Api',
    'migrations_namespace' => 'Migrations',
    'table_name' => 'migrations',
    'migrations_directory' => 'migrations'
];
