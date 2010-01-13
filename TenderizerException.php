<?php

class TenderizerException extends Exception
{
	private $payload;
	private $http_status;
	private $curl_info;

	public function __construct($payload, $http_status = 200, array $curl_info = array())
	{
		parent::__construct("{$http_status}: {$payload}", $http_st);

		$this->payload     = $payload;
		$this->http_status = $http_status;
	}

	public function getStatus()
	{
		return array
		(
			'status'  => $this->http_status,
			'message' => json_decode($this->payload),
			'file'    => self::getFile(),
			'line'    => self::getLine(),
			'curl'    => $this->curl_info
		);
	}

	public function __toString()
	{
		return self::getMessage();
	}
}