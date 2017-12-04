<?php 

namespace App\Middlewares;

//API request validation middleware

class CorsRequestMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{

		$host = $this->container['settings']['api']['hostname'];
		$ContentType = $this->container['settings']['api']['Content-type'];
		if(array_key_exists('CONTENT_TYPE', $request->getHeaders()) == false ||
		array_key_exists('Host', $request->getHeaders()) == false)
		{
			return $response->withStatus(403);
		}
		if($ContentType != $request->getHeader('Content-type')[0])
		{
			return $response->withStatus(403);
		}
		if($host != $request->getHeader('host')[0])
		{
			return $response->withStatus(403);	
		}
		$response = $next($request, $response);

		return $response;




	}

}