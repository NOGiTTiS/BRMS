<?php
/*
* Base Controller
* Loads the models and views
*/
class Controller
{
// โหลด Model
    public function model($model)
    {
// Require model file using APPROOT
        require_once APPROOT . '/models/' . $model . '.php';
// Instantiate model
        return new $model();
    }

// โหลด View
    public function view($view, $data = [])
    {
// Check for view file using APPROOT
        if (file_exists(APPROOT . '/views/' . $view . '.php')) {
            require_once APPROOT . '/views/' . $view . '.php';
        } else {
// View does not exist
            die('View does not exist: ' . APPROOT . '/views/' . $view . '.php');
        }
    }
}
