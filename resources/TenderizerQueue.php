<?php

class TenderizerQueue extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		return new TenderizerIterator($this->request('queues'), 'named_queues');
	}

	public function getById($queue_id)
	{
		return new TenderizerIterator(array($this->request("queues/{$queue_id}")));
	}
}