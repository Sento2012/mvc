<?php

use core\MVC;

if (!isset($_SESSION)) {
    session_start();
}

define('APP_ROOT', __DIR__);
define('WEB_ROOT', '/');

require_once(__DIR__ . '/core/mvc.php');
require_once(__DIR__ . '/core/model/model.php');
require_once(__DIR__ . '/core/view/view.php');
require_once(__DIR__ . '/core/controller/controller.php');
require_once(__DIR__ . '/config.php');
$isCLI = (php_sapi_name() == 'cli');
if (!$isCLI) {
    MVC::start($config);
} else {
    MVC::startCli($config);
}

?>