<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Session\Adapter\Files as SessionAdapter;

//Using the CLI factory default services container
$di = new CliDI();

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));


/**
 * Read the configuration
 */
$config = include __DIR__ . "/../app/config/config.php";
$configIni = new \Phalcon\Config\Adapter\Ini(__DIR__ . "/config/config.ini");
$config['is_tty'] = posix_isatty(STDOUT);
$config->merge($configIni);

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new \Phalcon\Loader();
$loader->registerDirs([
      __DIR__ . '/../app/tasks/'
]);
$loader->registerNamespaces([
    'Library' => $config->application->libraryDir,
    'Models' => $config->application->modelsDir,
    'Helpers' => $config->application->helpersDir
]);
$loader->register();

require $config->application->vendorDir . 'autoload.php';

$di->setShared('config', $config);

$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

$di->setShared('UserLib', function () use ($di) {
    if (!$di->getShared('session')->has('auth')) {
        return false;
    }
    $authSession = $di->getShared('session')->get('auth');
    if (!array_key_exists('id', $authSession)) {
        return false;
    }
    try {
        return new \Library\User\User($authSession['id']);
    } catch (\Exception $e) {
        return false;
    }
});

$di->setShared('Users', function () use ($di) {
    $UserLib = $di->getShared('UserLib');
    if (!$UserLib) {
        return false;
    }

    return $UserLib->getUsers();
});

$di->setShared('logger', function () {
    return [
        'debug' => 'debug.log',
        'info' => 'info.log',
        'warning' => 'warning.log'
    ];
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    ini_set('phalcon.orm.cast_on_hydrate', 1);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->db->adapter;
    $params = [
        'host'     => $config->db->host,
        'username' => $config->db->username,
        'password' => $config->db->password,
        'dbname'   => $config->db->dbname,
        'charset'  => $config->db->charset
    ];

    if ($config->db->adapter === 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('dbSystem', function () use ($config) {
    ini_set('phalcon.orm.cast_on_hydrate', 1);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->db_system->adapter;
    $params = [
        'host'     => $config->db_system->host,
        'username' => $config->db_system->username,
        'password' => $config->db_system->password,
        'dbname'   => $config->db_system->dbname,
        'charset'  => $config->db_system->charset
    ];

    if ($config->db->adapter === 'Postgresql') {
        unset($params['charset']);
    }

    return new $class($params);
});

//Create a console application
$console = new ConsoleApp();
$console->setDI($di);

/**
 * Process the console arguments
 */
$arguments = array();
$params = array();

foreach ($argv as $k => $arg) {
  if ($k == 1) {
    $arguments['task'] = $arg;
  } elseif ($k == 2) {
    $arguments['action'] = $arg;
  } elseif ($k >= 3) {
    $params[] = $arg;
  }
}

if (count($params) > 0) {
  $arguments['params'] = $params;
}

// define global constants for the current task and action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
  // handle incoming arguments
  $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
  echo $e->getMessage();
  exit(255);
}
