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
	protected static function request($url = null, $method = TenderizerConfig::HTTP_METHOD_POST, array $values = array())
	{
		$headers = array
		(
			'Accept: application/vnd.tender-v1+json',
			'Content-Type: application/json'
		);

		$curl = curl_init(TenderizerConfig::$service . '/' . TenderizerConfig::$site . (is_null($url) ? '' : "/{$url}"));

		switch(TenderizerConfig::AUTH_METHOD)
		{
			case 'basic':

				curl_setopt($curl, CURLOPT_USERPWD, TenderizerConfig::$email . ':' .TenderizerConfig::$password);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

				break;

			case 'sso':

				$headers[] = 'X-Multipass: ' . TenderizerConfig::$sso_token;

				break;

			case 'api':

				$headers[] = 'X-Tender-Auth: ' . TenderizerConfig::$api_token;

				break;
		}

		if($values)
		{
			$json_values = json_encode($values);
			$headers[] = 'Content-Length: ' . strlen($json_values);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json_values);
		}
		else 
		{
		  //$headers[] = 'Content-Length: 0';
		}

		curl_setopt($curl, CURLOPT_PUT,  false);
		curl_setopt($curl, CURLOPT_POST, false);
		if($method & TenderizerConfig::HTTP_METHOD_POST)
		{
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
		}
		else if($method & TenderizerConfig::HTTP_METHOD_PUT)
		{
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
		}
		else if($method & TenderizerConfig::HTTP_METHOD_DELETE)
		{
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		if(false === $response = curl_exec($curl))
		{
			throw new TenderizerException(curl_error($curl), curl_errno($curl));
		}

		$info = curl_getinfo($curl);

		curl_close($curl);

		if(false == in_array($info['http_code'], array(200, 201)))
		{
			throw new TenderizerException($response, $info['http_code'], $info);
		}

		if(preg_match('#^message:#i', $response))
		{
			throw new TenderizerException($response, 400);
		}

		return json_decode($response);
	}

	protected static function params(array $parameters = array(), $query_string = true)
	{
		$return = array();

		foreach($parameters as $key => $value)
		{
			$return[] = urlencode($key) . '=' . urlencode($value);
		}

		return ($query_string ? '?' : '') . implode('&', $return);
	}
}