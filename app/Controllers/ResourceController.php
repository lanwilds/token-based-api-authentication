<?php

namespace App\Controllers;

class ResourceController extends Controller
{
	public function index($request, $response)
	{
		$data = ['foo' => 'bar', 'site' => 'coderscoffe'];
		return $response->withJson($data);
	}
}