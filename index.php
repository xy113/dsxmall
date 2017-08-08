<?php
@ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);
define('DEBUG', true);
define('IN_DSXCMS', true);
define('ROOT_PATH',dirname(__FILE__).'/');
require ROOT_PATH.'Library/class.Application.php';
$application = new Application();
$application->start();