<?php

class TenderizerUser extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		return new TenderizerIterator($this->request('users'), 'users');
	}

	public function getById($user_id)
	{
		return new TenderizerIterator(array($this->request("users/{$user_id}")));
	}

	public function login($email, $password)
	{
		$values = array
		(
			'email'    => $email,
			'password' => $password
		);

		return new TenderizerIterator(array($this->request('users', self::HTTP_METHOD_POST, $values)));
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

		return new TenderizerIterator(array($this->request('users', self::HTTP_METHOD_POST, $values)));
	}
}