<?php

class TenderizerCategory extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("categories");

		return new TenderizerIterator($Response->categories, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($category_id)
	{
		$Response = array($this->request("categories/{$category_id}"));

		return new TenderizerIterator($Response);
	}
}