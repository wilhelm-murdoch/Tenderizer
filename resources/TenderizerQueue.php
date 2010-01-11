<?php

class TenderizerQueue extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("queues");

		return new TenderizerIterator($Response->queues, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($queue_id)
	{
		$Response = array($this->request("queues/{$queue_id}"));

		return new TenderizerIterator($Response);
	}
}