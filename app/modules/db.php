<?php

namespace modules;

use core\MVC;

/*
 * Класс для работы с БД
 */

class DB
{
    public $db;

    /*
     * Коннект к БД
     */
    public function connect()
    {
        $this->db = mysqli_connect(':/Applications/MAMP/tmp/mysql/mysql.sock', 'root',
            'root', 'bit_mvc') or die("база данных не доступна: " . mysql_error());
        mysqli_query("SET character_set_results=utf8", $this->db);
        mysqli_query("SET character_set_client=utf8", $this->db);
        mysqli_query("SET character_set_connection=utf8", $this->db);
        mb_language('uni');
        mb_internal_encoding('UTF-8');
        mysqli_select_db(MVC::$config['db']['dbname'], $this->db);
        mysqli_query("set names 'utf8'", $this->db);
    }

    /*
     * Начало транзакции
     */
    public function beginTransaction()
    {
        mysqli_begin_transaction($this->db);
        mysqli_autocommit($this->db, false);
    }

    /*
     * Сохранение изменений
     */
    public function commit()
    {
        if (mysqli_commit($this->db)) {
            return true;
        } else {
            mysqli_rollback($this->db);
            return false;
        }
    }

    /**
     * @param $sql - SQL запрос
     * @return resource
     * Запрос к БД
     */
    public function query($sql)
    {
        return mysqli_query($this->db, $sql);
    }

    /**
     * @param $res - ID коннекта
     * @return int
     * Количество записей по запросу
     */
    public function num_rows($res)
    {
        return @mysqli_num_rows($res);
    }

    /**
     * @param $res - ID коннекта
     * @return array
     * Получения данных
     */
    public function fetch($res)
    {
        return @mysqli_fetch_array($res, MYSQL_ASSOC);
    }

    /*
     * ID последнего вставленного элемента
     */
    public function insert_id()
    {
        return @mysqli_insert_id($this->db);
    }

    /*
     * Проверка коннекта
     */
    public function ping()
    {
        return mysqli_ping($this->db);
    }
}

?>