<?php

/***
 * TenderizerConfig
 *
 * This class contains configuration options for interaction with the Tender API.
 *
 * @package Tenderizer
 * @author Daniel Wilhelm II Murdoch <wilhelm.murdoch@gmail.com>
 * @license MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright Copyright (c) 2010, Daniel Wilhelm II Murdoch
 * @link http://www.thedrunkenepic.com
 * @version 1.0.0
 ***/
class TenderizerConfig
{
	const AUTH_METHOD = 'basic'; // Type of authentication to use [basic|sso|api]

	public static $service   = 'api.tenderapp.com'; // Tender API service domain
	public static $site      = ''; // Your Tender account site id
	public static $email     = ''; // Your Tender account email
	public static $password  = ''; // Your Tender account password
	public static $sso_token = ''; // Your Tender account SSO (Multi-Pass) token
	public static $api_token = ''; // Your Tender account API token


	/**
	 * The following constants are used to determine the type of request
	 * to use for a chosen API call.
	 */
	const HTTP_METHOD_GET    = 1;
	const HTTP_METHOD_POST   = 2;
	const HTTP_METHOD_PUT    = 4;
	const HTTP_METHOD_DELETE = 8;
}