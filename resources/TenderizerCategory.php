<?php

class TenderizerCategory extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		return new TenderizerIterator($this->request('categories'), 'categories');
	}

	public function getById($category_id)
	{
		return new TenderizerIterator(array($this->request("categories/{$category_id}")));
	}
}