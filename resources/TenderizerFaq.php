<?php

/***
 * TenderizerCategory
 *
 * This class contains PHP bindings for interaction with Tender categories.
 *
 * @package Tenderizer
 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright Copyright (c) 2010, Daniel Wilhelm II Murdoch
 * @link http://www.thedrunkenepic.com
 * @version 1.0.0
 ***/
class TenderizerFaq extends TenderizerRequest
{
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request("faqs?page={$page}"), 'faqs');
	}

	public static function getById($faq_id)
	{
		return new TenderizerIterator(array(self::request("faqs/{$faq_id}")));
	}

	public static function add($section_id, $title, $body, $published_at = null, $keywords = null)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'published_at' => $published_at,
			'keywords'     => $keywords
		);

		return new TenderizerIterator(array(self::request("sections/{$section_id}/faqs", TenderizerConfig::HTTP_METHOD_POST, $values)));
	}

	public static function update($faq_id, $title, $body, $published_at = null, $keywords = null)
	{
		$values = array
		(
			'title'        => $title,
			'body'         => $body,
			'published_at' => $published_at,
			'keywords'     => $keywords
		);

		return new TenderizerIterator(array(self::request("faqs/{$faq_id}", TenderizerConfig::HTTP_METHOD_PUT, $values)));
	}
}