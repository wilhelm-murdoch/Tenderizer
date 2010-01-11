<?php

class TenderizerSection extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("sections");

		return new TenderizerIterator($Response->sections, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($section_id)
	{
		$Response = array($this->request("sections/{$section_id}"));

		return new TenderizerIterator($Response);
	}
}