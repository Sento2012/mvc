<?php

namespace core\model;

/*
 * Класс модели
 */
abstract class Model
{
    /*
     * Конструктор
     */
    public function __construct()
    {
    }

    /*
     * Главная таблица
     */
    abstract public function get_table();

    /**
     * @param $data
     * @return mixed
     * Добавление записи
     */
    abstract public function add($data);

    /*
     * Получение всех записей
     */
    abstract public function getAll();
}

?>