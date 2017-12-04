<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tokens\Token;
//Database Model Eloquent for Admin Table
//For More Visit Laravel.com 
class Admin extends Model
{
	protected $table = 'admins';
	protected $primaryKey ='aid';

	protected $fillable = [
		'email',
		'name',
		'password',
		'ip_addr',
		'token',
	];

	public function setPassword($password)
	{
		
		$this->update([

			'password' => password_hash($password, PASSWORD_DEFAULT)

		]);
	}
	public function GetToken($aid)
	{
		$token = Token::generate();
		$res = Admin::where('aid',$aid)->update([
			'token' => $token,
		]);
		if($res)
		{
			return $token;
		}
		return false;
	}
}