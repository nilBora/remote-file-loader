<?php

class Downloads extends DownloadsObject
{
	private $_userInstance = null;
	
	public function __construct()
	{
		$this->_userInstance = new User;

		$this->_object = new DownloadsObject();
	}
	
	public function getLinksByToken($token)
	{
		$idUser = $this->_userInstance->getUserIDByToken($token);

		if (!$idUser) {
			return false;
		}
		$search = array(
			'id_user' => $idUser
		);

		$download = $this->_object->get($search);

		return $download['url'];
	}
}