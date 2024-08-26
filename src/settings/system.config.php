<?php
require_once './webhook/system.medoo.php';
//mibotam hosting
$mikbotamdata = new medoo([	'database_type' => 'sqlite', 'database_file' => './webhook/mibotam.db', ]);
//mysql localhost
//$mikbotamdata = new medoo([	'database_type' => 'mysql',	'database_name' => 'mikhmon', 'server' => 'localhost', 'username' => 'root', 'password' => '',	'charset' =>'utf8']);
?>