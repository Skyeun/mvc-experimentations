<?php

require_once __DIR__ . 'vendor/autoload.php';

use Core\Database\Database;
use Core\Router;
use Dotenv\Dotenv;

$dotenv = (Dotenv::create('.'))->load();
$database = new Database([
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'user'      => getenv('DB_USER'),
    'password'  => getenv('DB_PASSWORD')
], getenv('APP_ENV') !== 'prod' ? true : false);

if(session_status() == PHP_SESSION_NONE)
    session_start();

Router::route('^(.*)/$', 'LoginController::connectAction');
Router::route('^(.*)/disconnect$', 'LoginController::disconnectAction');
Router::route('^(.*)/register$', 'LoginController::registerAction');

Router::route('^(.*)/forgot-password$', function () {
    print "Forgot password uh?";
});

// Error fallback
Router::route('^(.*)$', 'ErrorController::NoRouteAction');

Router::execute($_SERVER['REQUEST_URI']);