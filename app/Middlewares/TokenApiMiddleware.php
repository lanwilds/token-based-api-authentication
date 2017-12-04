<?php 

namespace App\Middlewares;

//Check Token exist in requests
class TokenApiMiddleware extends Middleware
{

	public function __invoke($request, $response, $next)
	{
		if(!$request->getParam('token'))
		{
			return $response->withStatus(403);
		}
		$token = $request->getParam('token');
		if(!$this->container->Auth->validToken($token))
		{
			return $response->withStatus(403);
		}
		$response = $next($request, $response);

		return $response;




	}

}