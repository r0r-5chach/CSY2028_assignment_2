<?php
//Pick a file at random from the 'banners' directory and display it
$files = [];
foreach (new DirectoryIterator('./banners') as $file) {
	if ($file->isDot()) {
		continue;
	}

	if (!strpos($file->getFileName(), '.jpg')) {
		continue;
	}

	$files[] = $file->getFileName();
}

header('content-type: image/jpg');

$contents = file_get_contents('./banners/' . $files[rand(0,count($files)-1)]);

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header('content-length: ' . strlen($contents));

echo $contents;
