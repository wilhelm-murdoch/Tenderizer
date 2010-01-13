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
class TenderizerRequest
{
	private static $cache = array();

	protected static function request($url = null, $method = TenderizerConfig::HTTP_METHOD_POST, array $values = array())
	{
		$headers = array
		(
			'Accept: application/vnd.tender-v1+json',
			'Content-Type: application/json'
		);

		$curl = curl_init(is_null($url) ? TenderizerConfig::$service . '/' . TenderizerConfig::$site : TenderizerConfig::$service . '/' . TenderizerConfig::$site . "/{$url}");

		curl_setopt($curl, CURLOPT_USERPWD, TenderizerConfig::$email . ':' .TenderizerConfig::$password);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		if($values && $method & (TenderizerConfig::HTTP_METHOD_PUT | TenderizerConfig::HTTP_METHOD_POST))
		{
			$json_values = json_encode($values);

			if($method & TenderizerConfig::HTTP_METHOD_PUT)
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

		if($method & TenderizerConfig::HTTP_METHOD_DELETE)
		{
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		if(false === $response = curl_exec($curl))
		{
			throw new TenderizerException(curl_error($curl));
		}

		$info = curl_getinfo($curl);

		curl_close($curl);

		if(false === preg_match_all('#HTTP/.*\s+([0-9]+)#i', $response, $match))
		{
			throw new TenderizerException('Invalid header response.');
		}

		$http_status = $info['http_code'];

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