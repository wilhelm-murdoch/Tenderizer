<?php

class TenderizerFaq extends Tenderizer
{
	public function __construct($site, $email = null, $password = null)
	{
		parent::__construct($site, $email, $password);
	}

	public function getByPage($page = 1)
	{
		$Response = $this->request("faqs");

		return new TenderizerIterator($Response->faqs, $Response->offset, $Response->total, $Response->per_page);
	}

	public function getById($faq_id)
	{
		$Response = array($this->request("faqs/{$faq_id}"));

		return new TenderizerIterator($Response);
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

		$Response = array($this->request("sections/{$section_id}/faqs", array('Content-Type: application/json'), $values, self::HTTP_METHOD_POST));

		return new TenderizerIterator($Response);
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

		$Response = array($this->request("faqs/{$faq_id}", array('Content-Type: application/json'), $values, self::HTTP_METHOD_PUT));

		return new TenderizerIterator($Response);
	}
}