<?php
	require("opendb.php");

	$text = $_REQUEST['Body'];
	$code = $_REQUEST['From'];
	$code = substr($code, 2, 3);
	
  open();
	$text = filter_that_shit($text);
	if(strlen($text) != 0){
		$poop = "INSERT INTO reviews VALUES ('', '$code', '$text', NOW())";
		$result = mysql_query($poop);
	}
	mysql_close();
?>