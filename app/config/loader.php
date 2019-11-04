<?php

$loader = new \Phalcon\Loader();

$loader
    ->registerNamespaces([
        'Controllers' => $config->application->controllersDir,
        'Models' => $config->application->modelsDir,
        'Library' => $config->application->libraryDir
    ])
    ->register();

require $config->application->vendorDir . 'autoload.php';
