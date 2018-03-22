<?php

namespace App\Repositories;

use App\User;

class UserRepository implements UserRepositoryInterface
{

    protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function save($email)
	{
        $this->user->email = $email;
        $this->user->save();
	}

}