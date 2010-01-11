<?php

class TenderizerUser extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("users");

		return new TenderizerIterator($Response->users, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($user_id)
	{
		$Response = array($this->request("users/{$user_id}"));

		return new TenderizerIterator($Response);
	}

	public function login($email, $password)
	{
		$values = array
		(
			'email'    => $email,
			'password' => $password
		);

		$Response = array($this->request("users", array('Content-Type: application/json'), $values, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function add($email, $password, $confirmation, $name = '', $title = '')
	{
		$values = array
		(
			'email'                 => $email,
			'password'              => $password,
			'password_confirmation' => $confirmation,
			'name'                  => $name,
			'title'                 => $title
		);

		$Response = array($this->request("users", array('Content-Type: application/json'), $values, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}
}