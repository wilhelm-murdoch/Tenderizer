<?php

/***
 * TenderizerCategory
 *
 * This class contains PHP bindings for interaction with Tender categories.
 *
 * @package Tenderizer
 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright Copyright (c) 2010, Daniel Wilhelm II Murdoch
 * @link http://www.thedrunkenepic.com
 * @version 1.0.0
 ***/
class TenderizerUser extends TenderizerRequest
{
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request("users?page={$page}"), 'users');
	}

	public static function getById($user_id)
	{
		return new TenderizerIterator(array(self::request("users/{$user_id}")));
	}

	public static function login($email, $password)
	{
		$values = array
		(
			'email'    => $email,
			'password' => $password
		);

		return new TenderizerIterator(array(self::request('users', TenderizerConfig::HTTP_METHOD_POST, $values)));
	}

	public static function add($email, $password, $confirmation, $name = '', $title = '')
	{
		$values = array
		(
			'email'                 => $email,
			'password'              => $password,
			'password_confirmation' => $confirmation,
			'name'                  => $name,
			'title'                 => $title
		);

		return new TenderizerIterator(array(self::request('users', TenderizerConfig::HTTP_METHOD_POST, $values)));
	}
}