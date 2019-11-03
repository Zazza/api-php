<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'viewsDir'       => APP_PATH . '/views/',
        'libraryDir'     => APP_PATH . '/library/',
        'helpersDir'     => APP_PATH . '/helpers/',
        'cacheDir'       => BASE_PATH . '/var/cache/',
        'vendorDir'      => BASE_PATH . '/vendor/',
        'uploadDir'      => BASE_PATH . '/upload/',
        'logDir'         => BASE_PATH . '/var/log/'
    ]
]);
