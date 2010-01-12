<?php

/***
 * TenderizerIterator
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
class TenderizerIterator implements Iterator, ArrayAccess, Countable
{
   /**
	* The current position of the iterator.
	* @access Private
	* @var Integer
	*/
	private $results;


   /**
	* The current position of the iterator.
	* @access Private
	* @var Integer
	*/
	private $offset;


   /**
	* The current position of the iterator.
	* @access Private
	* @var Integer
	*/
	private $total;


   /**
	* The current position of the iterator.
	* @access Private
	* @var Integer
	*/
	private $per_page;


   /**
	* The current position of the iterator.
	* @access Private
	* @var Integer
	*/
	private $position;


   // ! Constructor Method

   /**
	* Instantiates class and defines instance variables.
	*
	* @param Object $DOMNodeList The result set of the last XPath query.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Void
	*/
	public function __construct($Results = null, $resource = null)
	{
		$this->results  = is_null($resource) ? $Results : (isset($Results->$resource) ? $Results->$resource : $Results->results);
		$this->offset   = isset($Results->offset) ? $Results->offset : null;
		$this->total    = isset($Results->total) ? $Results->total : null;
		$this->per_page = isset($Results->per_page) ? $Results->per_page : null;
		$this->position = 0;
	}


   // ! Accessor Method

   /**
	* Returns the current position of the iterator.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Object
	*/
	public function key()
	{
		return $this->position;
	}


   // ! Accessor Method

   /**
	* Returns the number of results.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Integer
	*/
	public function count()
	{
		return count($this->results);
	}


   // ! Executor Method

   /**
	* Moves the internal pointer to the next result.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Integer
	*/
	public function next()
	{
		return $this->position++;
	}


   // ! Executor Method

   /**
	* Moves the internal pointer to the previous result.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Integer
	*/
	public function rewind()
	{
		return $this->position = 0;
	}


   // ! Accessor Method

   /**
	* Returns the element assigned to the current pointer.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Object
	*/
	public function current()
	{
		return $this->offsetGet($this->position);
	}


   // ! Accessor Method

   /**
	* Used to determine whether the current pointer is valid.
	*
	* @param None
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function valid()
	{
		return $this->offsetExists($this->position);
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function seek($position, $return = true)
	{
		if($position <= $this->count() && $position >= 0)
		{
			$this->position = $position;

			if($return)
			{
				return $this->current();
			}

			return true;
		}

		return false;
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function offsetGet($position)
	{
		if($this->offsetExists($position))
		{
			if(isset($this->results[$position]->href) && preg_match('#([0-9]+)$#i', $this->results[$position]->href, $matches))
			{
				$this->results[$position]->id = $matches[1];
			}

			return $this->results[$position];
		}

		return null;
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function offsetSet($position, $value)
	{
		$this->results[$position] = $value;

		return true;
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function offsetUnset($position)
	{
		if($this->offsetExists($position))
		{
			unset($this->results[$position]);
		}

		return true;
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function offsetExists($position)
	{
		return isset($this->results[$position]);
	}


   // ! Executor Method

   /**
	* Moves the pointer to the specified index.
	*
	* @param Integer $index  The new position of the iterator.
	* @param Integer $return Returns the value of the new position.
	* @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
	* @since Build 1.0.1 Alpha
	* @access Public
	* @return Boolean
	*/
	public function __get($property)
	{
		return $this->$property;
	}
}