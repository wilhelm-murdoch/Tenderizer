<?php

// TODO: Implement caching mechanisms
// TODO: Allow for all 3 types of authentication
// TODO: Parameter validation (add $page params, etc...)
// TODO: Better error reporting
// TODO: Unit test
// TODO: Document
// TODO: Fix PUT updates


class TenderizerException extends Exception {}

try
{
	require_once 'constants.php';
	require_once 'TenderizerIterator.php';
	require_once 'Tenderizer.php';

	$Tenderizer = new Tenderizer(TENDER_SITE, TENDER_EMAIL, TENDER_PASSWORD);

	// Category: 17841

	echo '<pre>';
	print_r($Tenderizer->factory('site')->get()->current());
	echo '</pre>';

	exit();

	foreach($Tenderizer->factory('discussion')->getByPage() as $Discussion)
	{
		echo '<pre>';
		print_r($Discussion);
		echo '</pre>';
	}
}
catch(TenderizerException $TenderizerException)
{
	echo $TenderizerException->getMessage();
}