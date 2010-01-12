<?php

class TenderizerSite extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function get()
	{
		return new TenderizerIterator(array($this->request()));
	}
}