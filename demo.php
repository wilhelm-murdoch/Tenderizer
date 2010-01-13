<?php

// TODO: Fix PUT updates
// TODO: Address 'Discussion Actions' 404 messages

try
{
	foreach(array_merge(glob('Tenderizer*.php'), glob('resources/Tenderizer*.php')) as $file)
		if($file != 'TenderizerConfig.php')
			include_once $file;

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
	echo '<pre>';
	print_r($TenderizerException->getStatus());
	echo '</pre>';
}