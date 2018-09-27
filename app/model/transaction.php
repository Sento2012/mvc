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
class Transaction extends Model
{
    /*
     * Таблица БД
     */
    public function get_table()
    {
        return 'transactions';
    }

    /*
     * Заголовки полей
     */
    public function get_labels()
    {
        return [
            'transaction_time' => 'Время',
            'transaction_amount' => 'Сумма',
            'transaction_user_id' => 'Пользователь'
        ];
    }

    /*
     * Валидаторы
     */
    public function get_types()
    {
        return [
            'transaction_amount' => array('type' => 'integer')
        ];
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

    /**
     * @param $data
     * @return array|bool
     * Добавление записи
     */
    public function add($data)
    {
        $checker = new Checker();
        $status = $checker->check($data, $this->get_types());
        if (isset($status['error'])) {
            return ['error' => 'Поле ' . $this->get_labels()[$status['error']] . ' заполнено некорректно!'];
        }
        MVC::$db->query('INSERT INTO ' . $this->get_table() . ' (transaction_time, transaction_amount, transaction_user_id) VALUES (\'' . mysql_real_escape_string(time()) . '\',\'' . mysql_real_escape_string($data['amount']) . '\',\'' . mysql_real_escape_string(MVC::$user['user_id']) . '\')');

        return true;
    }
}

?>