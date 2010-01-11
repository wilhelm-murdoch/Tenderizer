<?php

class TenderizerDiscussion extends Tenderizer
{
	private $valid_states;

	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);

		$this->valid_states = array
		(
			'new', 'open', 'assigned', 'resolved', 'pending', 'deleted'
		);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("discussions");

		return new TenderizerIterator($Response->discussions, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}"));

		return new TenderizerIterator($Response->discussions, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getByState($state, $page = 1)
	{
		if(false == in_array($state, $this->valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.");
		}

		$Response = array($this->request("discussions/{$state}"));

		return new TenderizerIterator($Response->discussions, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getByCategoryIdAndState($category_id, $state = 'open', $page = 1)
	{
		if(false == in_array($state, $this->valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.");
		}

		$Response = array($this->request("categories/{$category_id}/discussions/{$state}"));

		return new TenderizerIterator($Response->discussions, $Response->offset, $Response->total, $Response->per_page);
	}

	public function add($category_id, $title, $body, $author_email, $author_name = '', $public = true, $skip_spam = true)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'author_email' => $published_at,
			'author_name'  => $keywords,
			'public'       => $public,
			'skip_spam'    => $skip_spam
		);

		$Response = array($this->request("categories/{$category_id}/discussions", array('Content-Type: application/json'), $values, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function reply($discussion_id, $body, $author_email, $author_name = '', $skip_spam = true)
	{
		$values = array
		(
			'body'         => $body,
			'author_email' => $published_at,
			'author_name'  => $keywords,
			'skip_spam'    => $skip_spam
		);

		$Response = array($this->request("discussions/{$discussion_id}/comments", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function toggle($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/toggle", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function resolve($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/resolve", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function unresolve($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/unresolve", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function queue($discussion_id, $queue_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/queue?queue={$queue_id}", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function unqueue($discussion_id, $queue_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/unqueue?queue={$queue_id}", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function acknowledge($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/acknowledge", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function restore($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/restore", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function move($discussion_id, $category_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}/change_category?to={$category_id}", array('Content-Type: application/json'), null, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
	}

	public function delete($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}", array('Content-Type: application/json'), null, self::HTTP_METHOD_DELETE));

		return new TenderizerIterator($Response);
	}

	public function spam($discussion_id)
	{
		$Response = array($this->request("discussions/{$discussion_id}?type=spam", array('Content-Type: application/json'), null, self::HTTP_METHOD_DELETE));

		return new TenderizerIterator($Response);
	}
}