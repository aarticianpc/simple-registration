<?php
ob_start();
session_start();

define('ROOT', dirname(__FILE__, 2));
const DS = DIRECTORY_SEPARATOR;
const CORE_PATH = ROOT . DS . 'Core' . DS;

$url = (!empty($_GET['url'])) ? $_GET['url'] : null;
require_once(CORE_PATH.'bootstrap.php');
