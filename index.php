<?php
date_default_timezone_set('Europe/Sarajevo');

session_start();

require_once "vendor/autoload.php";
require_once "app/Database.php";
require_once "app/App.php";

$app = new App();
$app::setDocRoot(dirname(__FILE__));
$app->run();