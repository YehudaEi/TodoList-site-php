<?php 
$start = time();
$connection = null;

function getConnection(&$connection){
	if($connection !== null){
		return $connection;
	}
	$connection = new PDO(
		'mysql:host=localhost;dbname=todo;charset=utf8',
		'root',
		''
	);
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	return $connection; 
}