<?php

namespace core;

use modules\DB;

/*
 * Основной класс работы с системой
 */
class MVC
{

    public static $config;
    public static $db;
    public static $request;
    public static $user;

    /**
     * @param $controller_name
     * @param $action_name
     * Инициализация системы
     */
    public static function init($controller_name, $action_name)
    {
        if ($controller_name == '' || $action_name == '') {
            $controller_name = 'site';
            $action_name = 'action_index';
        } else {
            $action_name = 'action_' . $action_name;
        }

        if (file_exists(__DIR__ . '/../app/controller/' . ucfirst($controller_name) . 'Controller.php')) {
            require_once(__DIR__ . '/../app/controller/' . ucfirst($controller_name) . 'Controller.php');
        } else {
            self::get404();
        }
        foreach (scandir(__DIR__ . '/../app/model/') as $filename) {
            $path = __DIR__ . '/../app/model/' . $filename;
            if (is_file($path)) {
                require_once($path);
            }
        }
        foreach (scandir(__DIR__ . '/../app/modules/') as $filename) {
            $path = __DIR__ . '/../app/modules/' . $filename;
            if (is_file($path)) {
                require_once($path);
            }
        }
        self::$db = new DB();
        self::$db->connect();
        self::$request['post'] = $_POST;
        self::$request['get'] = $_GET;
        self::$request['files'] = $_FILES;
        self::$request['method'] = $_SERVER['REQUEST_METHOD'];
        self::$user = $_SESSION['user'];

        $controller = ucfirst($controller_name) . 'Controller';
        $controller = new $controller();
        $action = $action_name;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            self::get404();
        }
    }

    /**
     * @param $config
     * Web режим
     */
    public static function start($config)
    {
        self::$config = $config;
        $routes = preg_split('/[\/\?]/isu', $_SERVER['REQUEST_URI']);

        $controller_name = $routes[1];
        $action_name = $routes[2];

        self::init($controller_name, $action_name);
    }

    /*
     * 404 ошибка
     */
    public static function get404()
    {
        header('Location: ' . WEB_ROOT . 'task/list');
        die();
    }

    /**
     * @param $config
     * Cli режим
     */
    public static function startCli($config)
    {
        self::$config = $config;
        $routes = preg_split('/[\/\?]/isu', $_SERVER['argv'][1]);

        $controller_name = $routes[0];
        $action_name = $routes[1];

        self::init($controller_name, $action_name);
    }

}

?>