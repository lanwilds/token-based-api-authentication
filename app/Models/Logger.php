<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Database Model Eloquent for logger Table
//For More Visit Laravel.com/eloquent 

class Logger extends Model
{
	protected $table = 'logger';
	protected $primaryKey ='id';
	protected $dates = [
		'logout_at',
	];
	protected $fillable = [
		'userId',
		'token',
		'logout_at',
		'ip_addr',
		'token',
	];
}