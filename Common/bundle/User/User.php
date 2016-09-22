<?php

class User extends UserObject
{
	private $_object = null;

	public function __construct()
	{
		$this->_object = new UserObject();
	}
	
	public function getUserIDByToken($token)
	{
		$search = array(
			'access_token' => $token
		);

		$user = $this->_object->get($search);

		return $user['id'];
	}
}