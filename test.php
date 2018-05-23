<?php
use BibliotecaDatabase;
include_once dirname(__FILE__) . 'Database/credentials.php';

$con= new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
$con->connect();
