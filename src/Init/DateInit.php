<?php 
namespace App\Init;

class DateInit
{

	public static function dateNow($format = 'Y-m-d h:i:s')
	{
		return \date_create_from_format($format, \date($format));
	}
}