<?php

include_once dirname(__FILE__) . '/Database/credentials.php';
include_once dirname(__FILE__) . '/Database/MysqlAdapter.php';

$con= new MysqlAdapter(array(DB_HOST, DB_USER,DB_PASSWORD,DB_NAME));
$con->query("CREATE TABLE User(Id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(Id),FullName char(60),Email char(60),Password char(12))");

