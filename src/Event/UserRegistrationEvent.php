<?php


/**
 * @Author: Armel <arbandry@gmail.com>
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