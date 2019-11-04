<?php

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
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

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Controllers');
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

$di->setShared('db', function () use ($config) {
    ini_set('phalcon.orm.cast_on_hydrate', 1);

    return new \Phalcon\Db\Adapter\Pdo\Mysql([
        'host' => $config->db->host,
        'dbname' => $config->db->dbname,
        'username' => $config->db->username,
        'password' => $config->db->password,
        'options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => 1,
        ],
    ]);
});

$di->set(
    "view",
    function () {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir("../apps/views/");
        return $view;
    }
);

