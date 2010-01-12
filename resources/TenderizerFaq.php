<?php

class TenderizerFaq extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		return new TenderizerIterator($this->request('faqs'), 'faqs');
	}

	public function getById($faq_id)
	{
		return new TenderizerIterator(array($this->request("faqs/{$faq_id}")));
	}

	public function add($section_id, $title, $body, $published_at = null, $keywords = null)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'published_at' => $published_at,
			'keywords'     => $keywords
		);

		return new TenderizerIterator(array($this->request("sections/{$section_id}/faqs", self::HTTP_METHOD_POST, $values)));
	}

	public function update($faq_id, $title, $body, $published_at = null, $keywords = null)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'published_at' => $published_at,
			'keywords'     => $keywords
		);

		return new TenderizerIterator(array($this->request("faqs/{$faq_id}", self::HTTP_METHOD_PUT, $values)));
	}
}