<?php

namespace App\Controllers;

use App\Auth\Auth;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
	public function index($request, $response)
	{

		

		return $response->getBody()->write($_COOKIE['token']);
	}
	public function getLogIn($request, $response)
	{
		//Validation form-request
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty(),
			
			'password' => v::notEmpty()->length(8, 50),

		]);

		//on fail of validation
		if($validation->failed()) {
			return $response->withStatus(402);
		}

		$email = $request->getParam('email');
		$password = $request->getParam('password');

		if($this->Auth->Attempt($email,$password))
		{
			return $response->withStatus(200);
		}
		
		return $response->withStatus(403);
	}
	public function getLogout($request, $response)
	{
		if($this->Auth->LogOut($request->getParam('token')))
		{
			return $response->withStatus(200);
		}
		return $response->withStatus(403);
	}
	public function getSignUp($request, $response)
	{
		//Validation form-request
		$validation = $this->validator->validate($request, [
			'email' => v::noWhitespace()->notEmpty()->emailAvailable(),
			
			'name' => v::notEmpty()->alpha(),

			'repassword' => v::notEmpty()->length(8, 50),
			
			'password' => v::notEmpty()->length(8, 50),


		]);

		//on fail of validation
		if($validation->failed()) {
			return $response->withStatus(402);
		}

		if($request->getParam('password') != $request->getParam('repassword'))
		{
			return $response->withStatus(403);
		}
		
		//set the credentials
		$name = $request->getParam('name');
		$email = $request->getParam('email');
		$password = $request->getParam('password');

		//send them to database
		$saveUser = $this->Auth->saveUser($name, $password, $email);
		//if saved 
		if($saveUser)
		{
			return $response->withStatus(201);
		}
		//if not saved
		return $response->withStatus(501);
	
	}
}