<?php

/*
|--------------------------------------------------------------------------
| Disqus settings
|--------------------------------------------------------------------------
|
| `app.shortname` - Tells the Disqus service your forum's shortname, which is the unique identifier for your website as
| registered on Disqus. If undefined, the Disqus embed will not load.
| `app.category` - Tells the Disqus service the category to be used for the current page. This is used when creating the
| thread on Disqus for the first time.
| `helpers.default_counter` - String, will be showed until Disqus loads comments count and then will be replaced
| with real value. Used just as loading indicator.
|
*/

return [
	'app' => [
		'shortname' => '',
		'category'  => null,
	],
	'html' => [
		'default_counter' => '-',
	],
];