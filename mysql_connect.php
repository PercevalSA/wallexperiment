<?php

/*
	$host = 'localhost';
	$port = 3306;
	$user = 'eleve.tou';
	$pass = 'et*301';
	$db = 'WallExperimentMA';
*/

	$user 		= 'root';
	$pass 		= 'root';
	$db 		= 'wallexperiment';
	$host 		= 'localhost';
	$port 		= 3306;
	$link		= false;

	$link = mysql_connect("$host:$port", $user, $pass);
	$db_selected = mysql_select_db($db);
?>