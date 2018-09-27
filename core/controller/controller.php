<?php

namespace core\controller;

use core\view\View;

/*
 * Класс контроллера
 */

class Controller
{

    public $model;
    public $view;

    /*
     * Конструктор
     */
    function __construct()
    {
        $this->view = new View();
    }

    /*
     * Index метод
     */
    function action_index()
    {
    }
}

?>