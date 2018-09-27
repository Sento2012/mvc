<?php

use app\model\User;
use core\controller\Controller;
use core\MVC;

/*
 * Контроллер для работы с пользователями
 */

class UserController extends Controller
{
    public $layout = 'index';

    /*
     * Логин
     */
    public function action_login()
    {
        $user = new User();
        if ((MVC::$request['method'] == 'POST') && $user->login(MVC::$request['post'])) {
            $this->view->redirect('task/list');
        }
        if (!isset(MVC::$user)) {
            $this->view->render('user/login', $this->layout, []);
        } else {
            $this->view->redirect('task/list');
        }
    }

    /*
     * Регистрация
     */
    public function action_registration()
    {
        $user = new User();
        if ((MVC::$request['method'] == 'POST') && $user->registration(MVC::$request['post'])) {
            $this->view->redirect('task/list');
        }
        if (!isset(MVC::$user)) {
            $this->view->render('user/registration', $this->layout, []);
        } else {
            $this->view->redirect('task/list');
        }
    }

    /*
     * Логаут
     */
    public function action_logout()
    {
        session_write_close();
        $this->view->redirect('task/list');
    }

    /*
     * Настройки
     */
    public function action_settings()
    {
        if (!isset(MVC::$user)) {
            $this->view->redirect('user/registration');
        } else {
            $user = new User();
            if (MVC::$request['method'] == 'POST') {
                $user->charge(MVC::$request['post']['amount']);
            }
            $this->view->render('user/settings', $this->layout, ['user' => $user->getUserInfo()]);
        }
    }

}

?>