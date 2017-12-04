<?php

use App\Middlewares\TokenApiMiddleware;

//Login Routes Guest Routes
$app->group('/account', function() {
	
	$this->get('/login', 'AuthController:index')->setName('auth.login');
	$this->post('/signup', 'AuthController:getSignUp')->setName('auth.signup');
	$this->post('/login', 'AuthController:getLogIn')->setName('auth.login');
});



//Protected Routes
$app->group('', function() {
	
	$this->get('/account/logout', 'AuthController:getLogout')->setName('auth.logout');
	
	$this->get('/', 'ResourceController:index')->setName('res.home');

})->add(new TokenApiMiddleware($container));

//add TokenApiMiddleware instance to create protected routes or route group

