<?php

namespace App\Controllers;

class Controller
{
	protected $container;
	public function __construct($container)
	{
		$this->container = $container;
	}
	
	//Taking Property that are trying to Accesse inside Slim DI Container 
	public function __get($property)
	{
		if($this->container->{$property}) {
			return $this->container->{$property};
		} 
	}
}