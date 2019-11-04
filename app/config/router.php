<?php

$router = new \Phalcon\Mvc\Router();

$api = new Phalcon\Mvc\Router\Group(
    [
        'controller' => 'api',
    ]
);
$api->setPrefix('/api/v1');

$api->addPost(
    '/document',
    [
        'action' => 'add'
    ]
);
$api->addGet(
    '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}',
    [
        'action' => 'getDocument'
    ]
);
$api->addGet(
    '/document/',
    [
        'action' => 'getList'
    ]
);
$api->addPatch(
    '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}',
    [
        'action' => 'edit'
    ]
);
$api->addPost(
    '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}/publish',
    [
        'action' => 'publish'
    ]
);

$router->mount($api);

return $router;
