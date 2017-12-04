<?php

namespace App\Tokens;

use App\Models\Admin;
use App\Models\Logger;
use App\Cookies\Cookie;

/*
You are free to edit what mechanisms you wanted to generate token
*/

class Token
{
	public function generate()
	{
		return uniqid('tokenid',true);
	}
	public function checkToken($token)
	{
		$user = Admin::where('token',$token)->where('aid',$_SESSION['user'])->first();
		$log = Logger::where('token',$token)->first();
		if($user->ip_addr == $_SERVER['REMOTE_ADDR'] || 
			$log->ip_addr == $_SERVER['REMOTE_ADDR'])
		{
				return true;
		}
		distoryToken($token);
		return false;
	}
	public function distoryToken($token)
	{
		return Cookie::unsetCookie($token);
	}
}