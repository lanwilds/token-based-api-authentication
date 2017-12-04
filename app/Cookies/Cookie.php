<?php

namespace App\Cookies;

/**
* Cookie Class
*/
class Cookie
{
	protected $container;
	public function __construct($container)
	{
		$this->container = $container;
	}

	public function setTokenCookie($token)
	{
		return setcookie("token", $token);
	}

	public function setCSRFCookie()
	{
		setcookie($this->container->csrf->getTokenNameKey(),$this->container->csrf->getTokenName());
		setcookie($this->container->csrf->getTokenValueKey(),$this->container->csrf->getTokenValue());
	}
	public function unsetCookie($token)
	{
		return setcookie("token", "", time() - 3600);
	}
	public function checkTokenCookie($token)
	{
		if($token == $_COOKIE['token'])
		{
			return true;
		}
		return false;
	}
}