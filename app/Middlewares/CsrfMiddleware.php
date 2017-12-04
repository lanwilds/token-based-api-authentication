<?php 

namespace App\Middlewares;

class CsrfMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		//CSRF Token setting to Cookies
		$this->container->Cookie->setCSRFCookie();

		$response = $next($request, $response);
		return $response;
	}
}