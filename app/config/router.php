<?php

$router = $di->getRouter();

$router->add(
    '/admin/static/constants',
    ['controller' => 'static', 'action' => 'constants']
);

$router->add(
    '/admin/static/subject/new',
    ['controller' => 'static', 'action' => 'subject_new']
);
$router->add(
    '/admin/static/subject/edit/([0-9]+)',
    ['controller' => 'static', 'action' => 'subject_edit', 'id' => 1]
);
$router->add(
    '/admin/static/subject/delete/([0-9]+)',
    ['controller' => 'static',  'action' => 'subject_delete', 'id' => 1]
);

$router->add(
    '/admin/static/bot_useragent/new',
    ['controller' => 'static', 'action' => 'bot_useragent_new']
);
$router->add(
    '/admin/static/bot_useragent/edit/([0-9]+)',
    ['controller' => 'static', 'action' => 'bot_useragent_edit', 'id' => 1]
);
$router->add(
    '/admin/static/bot_useragent/delete/([0-9]+)',
    ['controller' => 'static',  'action' => 'bot_useragent_delete', 'id' => 1]
);

$router->add(
    '/admin/static/os_version/new',
    ['controller' => 'static', 'action' => 'os_version_new']
);
$router->add(
    '/admin/static/os_version/edit/([0-9]+)',
    ['controller' => 'static', 'action' => 'os_version_edit', 'id' => 1]
);
$router->add(
    '/admin/static/os_version/delete/([0-9]+)',
    ['controller' => 'static',  'action' => 'os_version_delete', 'id' => 1]
);


$router->handle();
