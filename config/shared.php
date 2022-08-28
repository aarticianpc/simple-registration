<?php

/**
 * Check if debug is on and display errors
 */

function setReporting() {
    error_reporting(E_ALL);
    if(DEBUG === true) {
        ini_set('display_errors', 'On');
    } else {
        ini_set('display_errors', 'Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', LOG_PATH.'error.log');
    }
}

/**
 * Check for Magic Quotes and remove them
 */
function stripSlashesDeep($value) {
    return is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
}

function removeMagicQuotes() {
    $_GET = stripSlashesDeep($_GET);
    $_POST = stripSlashesDeep($_POST);
    $_COOKIE = stripSlashesDeep($_COOKIE);
}

/**
 * Check register globals and remove them
 */

function unregisterGlobal() {
    if(ini_get('register_globals')) {
        $arr = [
            '_SESSION',
            '_POST',
            '_GET',
            '_COOKIE',
            '_REQUEST',
            '_SERVER',
            '_ENV',
            '_FILES'
        ];
        foreach ($arr as $val) {
            foreach ($GLOBALS[$val] as $key => $var) {
                if($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }

    }
}

/**
 * Main function
 */

function callHook() {
    global $url;

    $urlArray = explode('/', $url);

    $queryString = [];
    $action = '';

    $controller = $urlArray[0];
    array_shift($urlArray);

    if(!empty($urlArray[0])) {
        $action = $urlArray[0];
        array_shift($urlArray);
        $queryString = $urlArray;
    }

    if(empty($controller)) {
        $controller = 'User';
        $action = !empty($_SESSION['user']) ? 'dashboard' :'login';
    }

    $controllerName = $controller;
    $controller = ucwords($controller);

    $model = Inflection::singularize($controller);
    $controller .= 'Controller';

    if(class_exists($controller)) {
        $dispatch = new $controller($controllerName, $action, $model);
    } else {
        $controller = 'NotFoundController';
        $action = 'index';
        $dispatch = new NotFoundController($controller, $action);
    }
    if((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch, 'beforeAction'), $queryString);
        call_user_func_array(array($dispatch, $action), $queryString);
    }
}

function myAutoload($classname){
    if(file_exists(CLASSES_PATH.strtolower($classname).'.class.php')) {
        require_once (CLASSES_PATH.strtolower($classname).'.class.php');
    }
    else if(file_exists(CONTROLLER_PATH.strtolower($classname).'.php')) {
        require_once(CONTROLLER_PATH.strtolower($classname).'.php');
    } else if(file_exists(MODEL_PATH.strtolower($classname).'.php')) {
        require_once(MODEL_PATH.strtolower($classname).'.php');
    }
}

spl_autoload_register('myAutoload');
setReporting();
removeMagicQuotes();
unregisterGlobal();
callHook();