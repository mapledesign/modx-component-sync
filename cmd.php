<?php
/*
 * WARNING! Currently this code is naive. If you dump everything to the file 
 * system, modify something in the database and load it back - the code will 
 * overwrite your changes.
 * 
 */

define('MODX_API_MODE', true);
include '../../../index.php';

$tt = array('snippets', 'chunks', 'plugins', 'templates');
$foldername = '_db';
$eol = ''; // normalize line ending. empty (do not convert - leave as is), lf - to unix, cr - to mac,  crl - to windows 
	
if ($argv[1] == 'dump') {
  $class = 'ComponentDump';
} else if ($argv[1] == 'load') {
  $class = 'ComponentLoad';
} else {
  die("Option '{$argv[1]}' is unknown\nThe possible options are:\n\tload\n\tdump\n");
}

require_once dirname(__FILE__)."/classes/$class.php";
foreach($tt as $t) {
	/* @var $c ComponentLoad */
  try {
	$c = new $class($modx, $t, $foldername, $eol);
	$c->run();
	echo $c->getStats();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}