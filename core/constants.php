<?php
namespace Core;

/**
 * Paths
 */
define('CONFIG_PATH', ROOT.DS.'config'.DS);
define('LOG_PATH', ROOT.DS.'storage'.DS.'logs'.DS);
define('APP_PATH', ROOT.DS.'app'.DS);
define('CONTROLLER_PATH', APP_PATH.'controllers'.DS);
define('MODEL_PATH', APP_PATH.'models'.DS);
define('CLASSES_PATH', CORE_PATH.'Classes'.DS);
define('VIEWS_PATH', ROOT.DS.'app'.DS.'views'.DS);

/**
 * App constants
 */
define('APP_URL', $_ENV['APP_URL']);
define('DEBUG', $_ENV['APP_DEBUG']);
