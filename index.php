<?php
define('DEBUG', true);
define('IN_DSXCMS', true);
define('ROOT_PATH',dirname(__FILE__).'/');
require ROOT_PATH.'Library/class.Application.php';
$application = new Application();
$application->start();