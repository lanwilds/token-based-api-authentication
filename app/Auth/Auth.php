<?php

namespace App\Auth;

use App\Models\Admin;

use App\Models\Logger;

use App\Cookies\Cookie;

use App\Tokens\Token;
//Turn off Error reporting 
// because it occurs unexpected output buffer
error_reporting(0);

class Auth
{
	public function index()
	{
		return true;
	}
	public function saveUser($name, $password, $email)
	{
		$res = Admin::create([
			'name' => $name,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'email' => $email,
			'ip_addr' => $_SERVER['REMOTE_ADDR'],
		]);
		if($res)
		{
			return $this->Attempt($email,$password);
			
		}
		return false;
	}
	public function Attempt($email,$password)
	{
		$user = Admin::where('email', $email)->first();
		if(!$user)
		{
			return false;
		}

		if(password_verify($password, $user->password))
		{	
			$token = Admin::GetToken($user->aid);
			if($token)
			{
				//Successful Authenticated Stage
				Cookie::setTokenCookie($token);
				Logger::create([
					'userId' => $user->aid,
					'token' => $token,
					'ip_addr' => $_SERVER['REMOTE_ADDR'],
				]);
				//Set Token as Session
				$_SESSION['token'] = $token;
				$_SESSION['user'] = $user->aid;
				return true;
			}
			
		}

		return false;
	}

	public function LogOut($token)
	{
		if($token == $_SESSION['token'])
		{
			if(Admin::where('token',$token)->where('aid',$_SESSION['user'])->count() == 1)
			{
				$user = Admin::where('token',$token)
				->where('aid',$_SESSION['user'])
				->first();
				$res = Admin::where('aid',$user->aid)->update([
					'token' => null
				]);
				if($res)
				{
					Logger::where('userId',$user->aid)->update([
						'logout_at' => date("Y-m-d H:i:s"),
					]);
					Cookie::unsetCookie($token);
					unset($_SESSION['user']);
					unset($_SESSION['token']);
					return true;
				}
				return false;
			}
		}
		return false;
	}

	public function validToken($token)
	{
		//Token Validation
		//1. Session and Cookie level
		if($token == $_SESSION['token'] || Cookie::checkTokenCookie($token))
		{
			//2.Login Database and Logger level
			return Token::checkToken($token);
		}
		unset($_SESSION['user']);
		unset($_SESSION['token']);
		Token::distoryToken($token);
		return false;
	}	
}