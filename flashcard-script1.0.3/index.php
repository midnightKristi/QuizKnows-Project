<?php

if(isset($_GET['remove'])) {
	$param = $_GET['remove'];
	if(strcmp($param, 'true') == 0) {
		//remove install directory
		Delete(__DIR__.'/install');
	}
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';

function Delete($path)
{
	if (is_dir($path) === true)
	{
		$files = array_diff(scandir($path), array('.', '..'));

		foreach ($files as $file)
		{
			Delete(realpath($path) . '/' . $file);
		}

		return rmdir($path);
	}
	else if (is_file($path) === true)
	{
		return unlink($path);
	}

	return false;
}
