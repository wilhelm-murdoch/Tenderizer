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
class TenderizerQueue extends TenderizerRequest
{
	public static function get($page = 1)
	{
		return new TenderizerIterator(self::request("queues?page={$page}"), 'named_queues');
	}

	public static function getById($queue_id)
	{
		return new TenderizerIterator(array(self::request("queues/{$queue_id}")));
	}
}