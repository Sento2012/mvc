<?php

namespace app\model;

use core\model\Model;
use core\MVC;

/**
 * Class User - класс для работы с пользователем
 * @package app\model
 * user_name - Имя пользователя
 * user_pass - Пароль пользователя
 * user_priv - Привилегии пользователя
 */
class User extends Model
{
    /*
     * Таблица БД
     */
    public function get_table()
    {
        return 'users';
    }

    /*
     * Заголовки полей
     */
    public function get_labels()
    {
        return [
            'user_name' => 'Имя',
            'user_pass' => 'Пароль',
            'user_priv' => 'Привилегии'
        ];
    }

    /*
     * Валидаторы
     */
    public function get_types()
    {
        return [
            'user_name' => array('type' => 'regex', 'regex' => '/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/'),
            'user_pass' => array('type' => 'string'),
        ];
    }

    /**
     * @param $data - Array данные пользователя
     * @return bool
     * Логин
     */
    public function login($data)
    {
        $qisset = MVC::$db->query('SELECT * FROM ' . $this->get_table() . ' WHERE user_name=\'' . mysql_real_escape_string($data['user_name']) . '\' LIMIT 1');
        if (MVC::$db->num_rows($qisset) == 0) {
            return false;
        }
        $user = MVC::$db->fetch($qisset);
        if (md5($data['user_name'] . ':' . $data['user_pass']) == $user['user_pass']) {
            $_SESSION['user'] = $user;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $data - Array данные пользователя
     * @return bool
     * Регистрация пользователя
     */
    public function registration($data)
    {
        if ($data['user_pass'] != $data['re_user_pass']) {
            return false;
        }
        $checker = new Checker();
        if (!$checker->check($data, $this->get_types())) {
            return false;
        }
        MVC::$db->query('INSERT INTO ' . $this->get_table() . ' (user_name,user_pass) VALUES (\'' . mysql_real_escape_string($data['user_name']) . '\',\'' . mysql_real_escape_string(md5($data['user_name'] . ':' . $data['user_pass'])) . '\')');

        return true;
    }

    /*
     * Получение всех записей пользователя
     */
    public function getAll()
    {
        $qtask = MVC::$db->query('SELECT * FROM ' . $this->get_table());
        while ($task = MVC::$db->fetch($qtask)) {
            $out[] = $task;
        }

        return $out;
    }

    /*
     * Получение информации по текущему пользователю
     */
    public function getUserInfo()
    {
        $quser = MVC::$db->query('SELECT * FROM ' . $this->get_table() . ' WHERE user_id = ' . MVC::$user['user_id'] . ' LIMIT 1');
        $user = MVC::$db->fetch($quser);

        return $user;
    }

    /**
     * Списание средств
     * @param $amount
     * @return mixed
     */
    public function charge($amount)
    {
        MVC::$db->beginTransaction();
        $transaction = new Transaction();
        $transaction->add(['transaction_amount' => $amount]);
        MVC::$db->query('UPDATE ' . $this->get_table() . ' SET user_balance = user_balance - ' . $amount);

        return MVC::$db->commit();
    }

    /**
     * @param $data
     * @return array|bool
     * Добавление записи
     */
    public function add($data)
    {
        return true;
    }
}

?>