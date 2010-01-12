<?php

// TODO: Implement caching mechanisms
// TODO: Allow for all 3 types of authentication
// TODO: Parameter validation (add $page params, etc...)
// TODO: Better error reporting
// TODO: Unit test
// TODO: Document
// TODO: Fix PUT updates

try
{
	foreach(glob('Tenderizer*.php') as $file)
		include_once $file;

	foreach(glob('resources/Tenderizer*.php') as $file)
		include_once $file;

	// Category: 17841

	echo '<pre>';
	print_r(TenderizerCategory::get());
	echo '</pre>';
}
catch(TenderizerException $TenderizerException)
{
	echo $TenderizerException->getMessage();
}