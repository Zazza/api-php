<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Mvc\Dispatcher;

$di->setShared('config', $config);

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->site->baseUri);

    return $url;
});

$di->set('dispatcher', function () use ($di) {
    $eventsManager = $di->getShared('eventsManager');

    $SecurityPlugin = new \Library\Acl\SecurityPlugin();
    $eventsManager->attach('dispatch', $SecurityPlugin);

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Controllers');
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->setShared('view', function () use ($config) {
    $view = new View();
    $view
        ->setViewsDir($config->application->viewsDir)
        ->setLayoutsDir($config->application->viewsDir)
        ->setPartialsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            $config->site->DEBUG ? $volt_debug = true : $volt_debug = false;
            $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => $volt_debug,
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('round', 'round');

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
        // Generate Template files uses PHP itself as the template engine
    ));
    $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    return $view;
});

$di->setShared('simple_view', function () use ($config) {
    $view = new \Phalcon\Mvc\View\Simple();
    $view->setViewsDir($config->application->viewsDir);
    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {
            $config->site->DEBUG ? $volt_debug = true : $volt_debug = false;
            $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);
            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_',
                'compileAlways' => $volt_debug,
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('round', 'round');

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
        // Generate Template files uses PHP itself as the template engine
    ));
    return $view;
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

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    return new FlashSession([
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ]);
});

$di->set(
    'TagsCurrency',
    function () {
        return new \Helpers\Currency();
    }
);

/**
 * Start the session the first time some component request the session service
 */
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
