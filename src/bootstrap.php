<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (getenv('APP_ENV') !== 'test') {
	require_once dirname(__DIR__) . '/config/routing/router.php';
}

use Core\Database\Connector;
use Dotenv\Dotenv;


if (file_exists(dirname(__DIR__) . '/config/.env.local')) {
	(Dotenv::create(dirname(__DIR__) . '/config/', '.env'))->load();
	(Dotenv::create(dirname(__DIR__) . '/config/', '.env.local'))->overload();

	if (file_exists(dirname(__DIR__) . '/config/.env.test') && getenv('APP_ENV') === 'test') {
		(Dotenv::create(dirname(__DIR__) . '/config/', '.env.test'))->overload();
	}
} else {
	(Dotenv::create(dirname(__DIR__) . '/config/', '.env'))->load();
}

$database = new Connector([
	'host'      => getenv('DB_HOST'),
	'database'  => getenv('DB_NAME'),
	'user'      => getenv('DB_USER'),
	'password'  => getenv('DB_PASSWORD'),
], getenv('APP_ENV') !== 'prod' ? true : false);

if(session_status() == PHP_SESSION_NONE)
	session_start();