<?php
session_start();

use Respect\Validation\Validator as v;

require '../vendor/autoload.php';

$app = new \Slim\App([
	'settings' => [
		'displayErrorDetails' => true,
		'db' => [
			'driver' => 'mysql',
			'host' => 'localhost',
			'database' => 'token_api',
			'username' => 'root',
			'password' => '',
			'charset' => 'latin1',
			'collation' => 'latin1_swedish_ci',
			'prefix' => '',
		],
		'api' => [
			'hostname' => 'localhost',
			'Content-type' => 'application/json',
		]
	],
]);



//Slim 3 DI Container
$container = $app->getContainer();

//Laravel's Elqouent Models for Powerful Database Access
//visit https://laravel.com/docs/5.5/eloquent
$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
	return $capsule;
};
//SLim-CSRF

$container['csrf'] = function($container) {
	return new \Slim\Csrf\Guard;
};

//Methods

$container['Auth'] = function($container) {
	return new \App\Auth\Auth;
};

$container['Cookie'] = function($container) {
	return new \App\Cookies\Cookie($container);
};

//Form-Data Validator RESPECT Validation Service
$container['validator'] = function ($container) {

	return new App\Validation\Validator;

};

//Controllers

$container['AuthController'] = function($container) {
	return new \App\Controllers\AuthController($container);
};

$container['ResourceController'] = function($container) {
	return new \App\Controllers\ResourceController($container);
};


//Middlewares
$app->add(new \App\Middlewares\CorsResponseMiddleware($container));
$app->add(new \App\Middlewares\CorsRequestMiddleware($container));
$app->add(new \App\Middlewares\CsrfMiddleware($container));

//CSRF Protection Enabled
//$app->add($container->csrf);

//Respect Validation Service 
//Custom Validation Rules
v::with('App\\Validation\\Rules\\');








require_once '../app/routes.php';