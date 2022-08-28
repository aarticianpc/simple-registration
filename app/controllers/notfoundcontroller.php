<?php

class NotFoundController extends Controller
{
    public function index() {
        $this->set('title', '404 - Not Found!');
    }
}