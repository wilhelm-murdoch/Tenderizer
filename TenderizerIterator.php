<?php

class TenderizerIterator implements Iterator, ArrayAccess, Countable
{
	private $results;
	private $offset;
	private $total;
	private $per_page;
	private $position;

	public function __construct($Results = null, $resource = null)
	{
		$this->results  = is_null($resource) ? $Results : (isset($Results->$resource) ? $Results->$resource : $Results->results);
		$this->offset   = isset($Results->offset) ? $Results->offset : null;
		$this->total    = isset($Results->total) ? $Results->offset : null;
		$this->per_page = isset($Results->per_page) ? $Results->offset : null;
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