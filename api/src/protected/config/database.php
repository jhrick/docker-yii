<?php
return [
	'connectionString' => 'mysql:host=mysql;port=3306;dbname=api',
	'username' => getenv('MYSQL_USER'),
	'password' => getenv('MYSQL_PASSWORD'),
	'charset' => 'utf8',
	'emulatePrepare' => true,
];