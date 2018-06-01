<?php
require_once 'constants.php';
require_once 'functions.php';

include_once ROOT_PATH . '/Model/User.php';
include_once ROOT_PATH . '/Model/Event.php';
session_start();

include_once ROOT_PATH . '/Database/credentials.php';
include_once ROOT_PATH . '/Database/MysqlAdapter.php';

$con = new MysqlAdapter(array(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME));

require_once ROOT_PATH . '/includes/ReportReminder.php';
$reportReminder = new ReportReminder($con);
$reportReminder->remind();