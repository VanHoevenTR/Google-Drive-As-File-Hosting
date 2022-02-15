<?php
$file = isset($_REQUEST['file']) ? $_REQUEST['file'] : null;

if(file_exists($file)) {
	require 'inc/class.JavaScriptPacker.php';
	$my_script = mb_convert_encoding(file_get_contents($file), 'HTML-ENTITIES','UTF-8');
	$packer = new JavaScriptPacker($my_script, 'Numeric', true, false);
	$my_script = $packer->pack();
	echo $my_script;
} else exit('NOT FOUND');