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
		return new TenderizerIterator($this->request('discussions'), 'discussions');
	}

	public function getById($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}")));
	}

	public function getByState($state, $page = 1)
	{
		if(false == in_array($state, $this->valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.");
		}

		return new TenderizerIterator($this->request("discussions/{$state}"), 'discussions');
	}

	public function getByCategoryIdAndState($category_id, $state = 'open', $page = 1)
	{
		if(false == in_array($state, $this->valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.");
		}

		return new TenderizerIterator($this->request("categories/{$category_id}/discussions/{$state}"), 'discussions');
	}

	public function add($category_id, $title, $body, $author_email, $author_name = '', $public = false, $skip_spam = false)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'author_email' => $author_email,
			'author_name'  => $author_name,
			'public'       => $public,
			'skip_spam'    => $skip_spam
		);

		return new TenderizerIterator(array($this->request("categories/{$category_id}/discussions", $values)));
	}

	public function reply($discussion_id, $body, $author_email, $author_name = '', $skip_spam = true)
	{
		$values = array
		(
			'body'         => $body,
			'author_email' => $author_email,
			'author_name'  => $author_name,
			'skip_spam'    => $skip_spam
		);

		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/comments", $values)));
	}

	public function toggle($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/toggle")));
	}

	public function resolve($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/resolve")));
	}

	public function unresolve($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/unresolve")));
	}

	public function queue($discussion_id, $queue_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/queue?queue={$queue_id}")));
	}

	public function unqueue($discussion_id, $queue_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/unqueue?queue={$queue_id}")));
	}

	public function acknowledge($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/acknowledge")));
	}

	public function restore($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/restore")));
	}

	public function move($discussion_id, $category_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}/change_category?to={$category_id}")));
	}

	public function delete($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}", self::HTTP_METHOD_DELETE)));
	}

	public function spam($discussion_id)
	{
		return new TenderizerIterator(array($this->request("discussions/{$discussion_id}?type=spam", self::HTTP_METHOD_DELETE)));
	}
}