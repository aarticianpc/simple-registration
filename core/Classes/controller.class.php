<?php

class Controller {
    protected $_model;
    protected $_controller;
    protected $_action;
    protected $_template;

    public function __construct($controller, $action, $model = null) {

        $this->_action = $action;
        $this->_controller = $controller;

        if(!empty($model)) {
            $this->_model = $model;
            $this->$model = new $model;
        }
        $this->_template = new Template($controller, $action);
        $this->set('action', $this->_action);
    }

    protected function set($name, $value) {
        $this->_template->set($name, $value);
    }

    function __destruct() {
        $this->_template->render();
    }
}
