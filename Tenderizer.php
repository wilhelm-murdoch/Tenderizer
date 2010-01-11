<?php

class Tenderizer
{
	const HTTP_METHOD_GET    = 1;
	const HTTP_METHOD_POST   = 2;
	const HTTP_METHOD_PUT    = 4;
	const HTTP_METHOD_DELETE = 8;

	protected $site;
	protected $email;
	protected $password;
	protected $service;
	private $cache;

	public function __construct($site, $email = null, $password = null)
	{
		$this->site     = $site;
		$this->email    = $email;
		$this->password = $password;
		$this->service  = 'api.tenderapp.com';
		$this->cache    = array();
	}

	public function factory($resource)
	{
		$class_name = 'Tenderizer' . ucwords(strtolower($resource));
		$class_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . "{$class_name}.php";

		if(false == file_exists($class_path))
		{
			throw new TenderizerException("Class `{$class_name}` for resource `{$resource}` does not exist.");
		}

		require_once $class_path;

		if(false == class_exists($class_name))
		{
			throw new TenderizerException("Class `{$class_name}` for resource `{$resource}` does not exist.");
		}

		return new $class_name($this->site, $this->email, $this->password);
	}

	protected function request($url = null, array $headers = array(), array $values = array(), $method = self::HTTP_METHOD_GET)
	{
		$curl = curl_init(is_null($url) ? "{$this->service}/{$this->site}" : "{$this->service}/{$this->site}/{$url}");

		curl_setopt($curl, CURLOPT_USERPWD, "{$this->email}:{$this->password}");
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		if($values && $method & (self::HTTP_METHOD_PUT | self::HTTP_METHOD_POST))
		{
			$json_values = json_encode($values);

			if($method & self::HTTP_METHOD_PUT)
			{
				curl_setopt($curl, CURLOPT_PUT, true);
				curl_setopt($curl, CURLOPT_POST, false);

				$headers[] = 'Content-Length: ' . strlen($json_values);
			}
			else
			{
				curl_setopt($curl, CURLOPT_PUT, false);
				curl_setopt($curl, CURLOPT_POST, true);
			}

			curl_setopt($curl, CURLOPT_POSTFIELDS, $json_values);
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge($headers, array('Accept: application/vnd.tender-v1+json')));

		if(false === $response = curl_exec($curl))
		{
			throw new TenderizerException(curl_error($curl));
		}

		curl_close($curl);

		if(false === preg_match_all('#HTTP/.*\s+([0-9]+)#i', $response, $match))
		{
			throw new TenderizerException('Invalid header response.');
		}

		$http_status = array_pop(array_pop($match));

		$response_bits = explode("\r\n\r\n", $response);

		array_shift($response_bits);

		$response = implode("\r\n\r\n", $response_bits);


		switch($http_status)
		{
			case 200: // OK
			case 201: // Record created

				return json_decode($response);
				break;

			case 411: // Length required

			case 422: // Failed validation

				throw new TenderizerException("HTTP {$http_status}: {$response}");

				break;

			case 401: // Unauthorized

				break;

			case 404: // Page not found

				throw new TenderizerException("HTTP {$http_status}: The page you are looking for cannot be found.");

				break;

			case 406: // Invalid header
			default:

				throw new TenderizerException("HTTP {$http_status}: {$response}");

				break;
		}

		return true;
	}
}