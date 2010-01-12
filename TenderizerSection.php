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
class TenderizerSection extends TenderizerRequest
{
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request("sections?page={$page}"), 'sections');
	}

	public static function getById($section_id)
	{
		return new TenderizerIterator(array(self::request("sections/{$section_id}")));
	}
}