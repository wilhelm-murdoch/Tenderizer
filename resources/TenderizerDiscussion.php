<?php

/***
 * TenderizerDiscussion
 *
 * This class contains PHP bindings for interaction with Tender discussions. All functions within this
 * class can be called statically.
 *
 * <code>
 *     require_once 'TenderizerConfig.php';
 *     require_once 'TenderizerException.php';
 *     require_once 'TenderizerRequest.php';
 *     require_once 'TenderizerDiscussion.php';
 *
 *     $Discussion = TenderizerDiscussion::getById(1234);
 * </code>
 *
 * @package Tenderizer
 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright Copyright (c) 2010, Daniel Wilhelm II Murdoch
 * @link http://www.thedrunkenepic.com
 * @version 1.0.0
 ***/
class TenderizerDiscussion extends TenderizerRequest
{
   /**
	* A list of valid discussion states.
	* @access Public Static
	* @var Array
	*/
	private static $valid_states = array('new', 'open', 'assigned', 'resolved', 'pending', 'deleted');


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
		return new TenderizerIterator(self::request('discussions' . self::params(array('page' => $page))), 'discussions');
	}


   // ! Executor Method

   /**
	* Returns a specific discussion by id.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::getById($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function getById($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}")));
	}


   // ! Executor Method

   /**
	* Returns a list of discussions associated to a specified state.
	*
	* <code>
	*     $Discussions = TenderizerDiscussion::getByState($state, $page);
	* </code>
	*
	* @param Integer $category_id The ID of the category to search.
	* @param Integer $state       The state of the discussions to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator | TenderizerException
	*/
	public static function getByState($state, $page = 1)
	{
		if(false == in_array($state, self::$valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.", 422);
		}

		return new TenderizerIterator(self::request("discussions/{$state}" . self::params(array('page' => $page))), 'discussions');
	}


   // ! Executor Method

   /**
	* Returns a list of discussions associated with a specified category.
	*
	* <code>
	*     $Discussions = TenderizerDiscussion::getByCategoryId($category_id, $page);
	* </code>
	*
	* @param Integer $category_id The ID of the category to search.
	* @param Integer $page        The page number to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function getByCategoryId($category_id, $page = 1)
	{
		return new TenderizerIterator(self::request("categories/{$category_id}/discussions" . self::params(array('page' => $page))), 'discussions');
	}


   // ! Executor Method

   /**
	* Returns a list of discussions associated to a specified category and state combination.
	*
	* <code>
	*     $Discussions = TenderizerDiscussion::getByCategoryIdAndState($category_id, $state, $page);
	* </code>
	*
	* @param Integer $category_id The ID of the category to search.
	* @param Integer $state       The state of the discussions to return.
	* @param Integer $page        The page number to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator | TenderizerException
	*/
	public static function getByCategoryIdAndState($category_id, $state = 'open', $page = 1)
	{
		if(false == in_array($state, self::$valid_states))
		{
			throw new TenderizerException("State `{$state}` is not a valid option.", 422);
		}

		return new TenderizerIterator(self::request("categories/{$category_id}/discussions/{$state}" . self::params(array('page' => $page))), 'discussions');
	}


   // ! Executor Method

   /**
	* Adds a new discussion to the specified category. Will return the discussion if successful.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::add($category_id, $title, $body, $author_email, $author_name, $public, $skip_spam);
	* </code>
	*
	* @param Integer $category_id  The ID of the category to add to.
	* @param String  $title        The title of the discussion.
	* @param String  $body         The content of the discussion.
	* @param String  $author_email Email address of the submitter.
	* @param String  $author_name  Optional submitter name.
	* @param Boolean $public       Determines whether to set as public or private.
	* @param Boolean $skip_spam    Determines whether to skip spam validation.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function add($category_id, $title, $body, $author_email, $author_name = '', $public = false, $skip_spam = false)
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

		return new TenderizerIterator(array(self::request("categories/{$category_id}/discussions", TenderizerConfig::HTTP_METHOD_POST, $values)));
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
	public static function reply($discussion_id, $body, $author_email, $author_name = '', $skip_spam = true)
	{
		$values = array
		(
			'body'         => $body,
			'author_email' => $author_email,
			'author_name'  => $author_name,
			'skip_spam'    => $skip_spam
		);

		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/comments", TenderizerConfig::HTTP_METHOD_POST, $values)));
	}


   // ! Executor Method

   /**
	* Toggles a discussion's public & private status.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::toggle($discussion_id, $category_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function toggle($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/toggle")));
	}


   // ! Executor Method

   /**
	* Marks a discussion as resolved.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::resolve($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function resolve($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/resolve")));
	}


   // ! Executor Method

   /**
	* Marks a discussion as unresolved.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::unresolve($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function unresolve($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/unresolve")));
	}


   // ! Executor Method

   /**
	* Assigns a specified discussion to a queue.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::queue($discussion_id, $queue_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @param Integer $queue_id      The ID of the associated queue..
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function queue($discussion_id, $queue_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/queue" . self::params(array('queue' => $queue_id)))));
	}


   // ! Executor Method

   /**
	* Removes a specified discussion from a queue.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::unqueue($discussion_id, $queue_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @param Integer $queue_id      The ID of the associated queue.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function unqueue($discussion_id, $queue_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/unqueue" . self::params(array('queue' => $queue_id)))));
	}


   // ! Executor Method

   /**
	* Acknowledges a specified discussion
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::acknowledge($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to acknowledge.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function acknowledge($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/acknowledge")));
	}


   // ! Executor Method

   /**
	* Restores a specified discussion
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::restore($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to restore.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function restore($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/restore")));
	}


   // ! Executor Method

   /**
	* Moves a discussion to another category.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::move($discussion_id, $category_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to modify.
	* @param Integer $category_id   The ID of the destination category.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function move($discussion_id, $category_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}/change_category" . self::params(array('to' => $category_id)))));
	}


   // ! Executor Method

   /**
	* Deletes a specified discussion.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::delete($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to mark.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function delete($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}", TenderizerConfig::HTTP_METHOD_DELETE)));
	}


   // ! Executor Method

   /**
	* Marks a specified discussion as spam. Will return the modified record.
	*
	* <code>
	*     $Discussion = TenderizerDiscussion::spam($discussion_id);
	* </code>
	*
	* @param Integer $discussion_id The ID of the discussion to mark.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function spam($discussion_id)
	{
		return new TenderizerIterator(array(self::request("discussions/{$discussion_id}" . self::params(array('type' => 'spam')), TenderizerConfig::HTTP_METHOD_DELETE)));
	}
}