<?php

class TenderizerSection extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		return new TenderizerIterator($this->request('sections'), 'sections');
	}

	public function getById($section_id)
	{
		return new TenderizerIterator(array($this->request("sections/{$section_id}")));
	}
}