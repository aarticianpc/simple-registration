<?php

use Core\DotENV;

/**
 * Fetch & Initialize configuration from .env file
*/
require_once(CORE_PATH.'Processor'.DS.'ProcessorInterface.php');
require_once(CORE_PATH.'Processor'.DS.'AbstractProcessor.php');
require_once(CORE_PATH.'Processor'.DS.'BooleanProcessor.php');
require_once(CORE_PATH.'Processor'.DS.'QuotedProcessor.php');
require_once('DotENV.php');
(new DotENV(ROOT.DS.'.env'))->load();

/**
 * Define global constants
*/
require_once(ROOT.DS.'core'.DS.'constants.php');

/**
 * define db configuration
 */
require_once(CONFIG_PATH.'database.php');

/**
 * Load Inflection class
 */
$irregularWords = [];
require_once(CLASSES_PATH.'inflection.class.php');

/**
 * Load cache class
 */
require_once(CLASSES_PATH.'cache.class.php');
/**
 * Load all controllers & models based on route
*/
require_once(CONFIG_PATH.'shared.php');