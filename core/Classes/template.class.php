<?php

class Template {
    protected $variables = [];
    protected $_controller;
    protected $_action;

    public function __construct($controller, $action) {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /**
     * Set variables
     * @param $name
     * @param $value
     * @return void
     */
    public function set($name, $value) {
        $this->variables[$name] = $value;
    }

    public function render() {
        extract($this->variables);

        if(file_exists(VIEWS_PATH.$this->_controller.DS.'header.php')) {
            include(VIEWS_PATH.$this->_controller.DS.'header.php');
        } else {
            include(VIEWS_PATH.DS.'header.php');
        }

        if(file_exists(VIEWS_PATH.$this->_controller.DS.$this->_action.'.php')) {
            include(VIEWS_PATH.$this->_controller.DS.$this->_action.'.php');
        } else {
            include(VIEWS_PATH.DS.'404.php');
        }

        if(file_exists(VIEWS_PATH.$this->_controller.DS.'footer.php')) {
            include(VIEWS_PATH.$this->_controller.DS.'footer.php');
        } else {
            include(VIEWS_PATH.DS.'footer.php');
        }

    }
}