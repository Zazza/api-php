<?php
use Phalcon\DI;
use Phalcon\DI\FactoryDefault;

$di = new FactoryDefault();

$config = include __DIR__ . "/../app/config/config.php";
$configS = new \Phalcon\Config\Adapter\Ini(__DIR__."/../app/config/config.ini");
$config->merge($configS);
$configS = new \Phalcon\Config\Adapter\Ini(__DIR__."/../app/config/config-test.ini");
$config->merge($configS);

require __DIR__ . '/../app/config/services.php';
include __DIR__ . '/../app/config/loader.php';

$loader->registerDirs(
    array(
        __DIR__
    )
);
$loader->register();
