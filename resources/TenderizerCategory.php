<?php

/***
 * TenderizerCategory
 *
 * This class contains PHP bindings for interaction with Tender categories All functions within this
 * class can be called statically.
 *
 * <code>
 *     require_once 'TenderizerConfig.php';
 *     require_once 'TenderizerException.php';
 *     require_once 'TenderizerRequest.php';
 *     require_once 'TenderizerCategory.php';
 *
 *     $Discussion = TenderizerCategory::getById(1234);
 * </code>
 *
 * @package Tenderizer
 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright Copyright (c) 2010, Daniel Wilhelm II Murdoch
 * @link http://www.thedrunkenepic.com
 * @version 1.0.0
 ***/
class TenderizerCategory extends TenderizerRequest
{
   // ! Executor Method

   /**
	* Will return a paginated list of categories associated with your Tender account.
	*
	* <code>
	*     $Categories = TenderizerCategory::get();
	*
	*     $Categories = TenderizerCategory::get($page);
	* </code>
	*
	* @param Integer $page The page number to return.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request('categories' . self::params(array('page' => $page))), 'categories');
	}


   // ! Executor Method

   /**
	* Attempts to return a single category record associated with the provided `$category_id`.
	*
	* <code>
	*     $Category = TenderizerCategory::getById($category_id);
	* </code>
	*
	* @param Integer $category_id The id of the category to search for.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @access Public Static
	* @return Object TenderizerIterator
	*/
	public static function getById($category_id)
	{
		return new TenderizerIterator(array(self::request("categories/{$category_id}")));
	}
}