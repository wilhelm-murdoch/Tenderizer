<?php

// TODO: Implement caching mechanisms
// TODO: Allow for all 3 types of authentication
// TODO: Parameter validation (add $page params, etc...)
// TODO: Better error reporting
// TODO: Unit test
// TODO: Document
// TODO: Fix PUT updates
// TODO: Address 'Discussion Actions' 404 messages
// TODO: Add TenderizerDiscussion::getByCategoryId($category_id); method

try
{
	foreach(array_merge(glob('Tenderizer*.php'), glob('resources/Tenderizer*.php')) as $file) include_once $file;

	/**
	 * The following code will display the first page of categories as well as
	 * the first page of all associated discussions:
	 */
	foreach(TenderizerCategory::get() as $Category)
	{
		echo "<h2>{$Category->name}</h2>";
		echo '<ol>';
		foreach(TenderizerDiscussion::getByCategoryId($Category->id) as $Discussion)
		{
			echo "<li>{$Discussion->title}</li>";
		}
		echo '</ol>';
	}
}
catch(TenderizerException $TenderizerException)
{
	echo $TenderizerException->getMessage();
}