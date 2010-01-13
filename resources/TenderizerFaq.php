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
   // ! Executor Method

   /**
	* Returns a paginated list of discussions.
	*
	* <code>
	*     $Discussions = TenderizerDiscussion::get();
	*
	*     $Discussions = TenderizerDiscussion::get($page);
	* </code>
	*
	* @param Integer $page The page number to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request("faqs?page={$page}"), 'faqs');
	}


   // ! Executor Method

   /**
	* Returns a paginated list of discussions.
	*
	* <code>
	*     $Discussions = TenderizerDiscussion::get();
	*
	*     $Discussions = TenderizerDiscussion::get($page);
	* </code>
	*
	* @param Integer $page The page number to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function getById($faq_id)
	{
		return new TenderizerIterator(array(self::request("faqs/{$faq_id}")));
	}


   // ! Executor Method

   /**
	* Adds a new reply to the specified discussion. Will return the discussion if successful.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::reply($discussion_id, $body, $author_email, $author_name, $skip_spam);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to reply to.
	* @param String  $body          The content of the reply.
	* @param String  $author_email  Email address of the submitter.
	* @param String  $author_name   Optional submitter name.
	* @param Boolean $skip_spam     Determines whether to skip spam validation.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
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


   // ! Executor Method

   /**
	* Adds a new reply to the specified discussion. Will return the discussion if successful.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::reply($discussion_id, $body, $author_email, $author_name, $skip_spam);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to reply to.
	* @param String  $body          The content of the reply.
	* @param String  $author_email  Email address of the submitter.
	* @param String  $author_name   Optional submitter name.
	* @param Boolean $skip_spam     Determines whether to skip spam validation.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
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