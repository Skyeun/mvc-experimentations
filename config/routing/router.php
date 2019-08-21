<?php

require_once dirname(__DIR__) . '/routing/login/login.php';

use Core\Router\Router;


// Error fallback
Router::route('^(.*)$', 'ErrorController::NoRouteAction');

Router::execute($_SERVER['REQUEST_URI']);