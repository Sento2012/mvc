<?php

namespace modules;

/*
 * Класс валидации данных
 */
class Checker
{
    /**
     * @param $data - входное поле
     * @param $rules - правило валидации
     * @return array|bool
     * Валидация данных
     */
    public function check($data, $rules)
    {
        foreach ($data as $key => $item) {
            if ($rules[$key]['type'] == 'string' && !is_string($item)) {
                return ['error' => $key];
            }
            if ($rules[$key]['type'] == 'regex' && !preg_match($rules[$key]['regex'], $item)) {
                return ['error' => $key];
            }
        }

        return true;
    }
}

?>