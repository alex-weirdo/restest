<?php

// директории для автозагрузки
$directories = array(
	'config',
	'classes'
);

foreach ($directories as $directory)
	foreach (scandir($directory) as $file) {
		if (strpos($file, '.php') === false || strpos($file, '-sample')) continue;
		require_once $directory . '/' . $file;
	}

require 'routes.php';
