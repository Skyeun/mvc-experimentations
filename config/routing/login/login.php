<?php

use Core\Router\Router;


Router::route('^(.*)/$', function () {
	print "This is the homepage!";
});
//Router::route('^(.*)/disconnect$', 'LoginController::disconnectAction');
//Router::route('^(.*)/register$', 'LoginController::registerAction');
//
//Router::route('^(.*)/forgot-password$', function () {
//	print "Forgot password uh?";
//});