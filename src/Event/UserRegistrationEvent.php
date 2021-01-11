<?php

/**
 * @Author: Armel Andrianimanana
 * @Date:   2021-01-11 15:21:50
 * @Last Modified by:   Armel
 * @Last Modified time: 2021-01-11 15:43:55
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;
 
class UserRegistrationEvent extends Event
{
	protected $user;
	const NAME = 'qcm.user.registration';

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function getUser():User
	{		
		return $this->user;
	}
}