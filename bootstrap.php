<?php

// директории для автозагрузки
$directories = array(
	'classes'
);

foreach ($directories as $directory)
	foreach (scandir($directory) as $file) {
		if (strpos($file, '.php') === false) continue;
		require_once $directory . '/' . $file;
	}

require 'routes.php';
