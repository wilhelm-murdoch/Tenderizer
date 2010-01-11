<?php

class TenderIterator implements Iterator, ArrayAccess, Countable
{
	private $results;
	private $offset;
	private $total;
	private $per_page;
	private $position;

	public function __construct(array &$results = array(), $offset = null, $total = null, $per_page = null)
	{
		$this->results  = &$results;
		$this->offset   = $offset;
		$this->total    = $total;
		$this->per_page = $per_page;
		$this->position = 0;
	}

	public function key()
	{
		return $this->position;
	}

	public function count()
	{
		return count($this->results);
	}

	public function next()
	{
		return $this->position++;
	}

	public function rewind()
	{
		return $this->position = 0;
	}

	public function current()
	{
		return $this->offsetGet($this->position);
	}

	public function valid()
	{
		return $this->offsetExists($this->position);
	}

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

	public function offsetSet($position, $value)
	{
		$this->results[$position] = $value;

		return true;
	}

	public function offsetUnset($position)
	{
		if($this->offsetExists($position))
		{
			unset($this->results[$position]);
		}

		return true;
	}

	public function offsetExists($position)
	{
		return isset($this->results[$position]);
	}

	public function __get($property)
	{
		return $this->$property;
	}
}