<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Router;

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