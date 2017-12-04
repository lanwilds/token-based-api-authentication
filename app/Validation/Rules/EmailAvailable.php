<?php


namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

use App\Models\Admin;

class EmailAvailable extends AbstractRule
{

	public function validate($input)
	{
		$email = Admin::where('email', $input)->count();
		if($email>0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

}