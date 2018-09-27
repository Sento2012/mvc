<?php

namespace core\view;

/*
 * Класс отображения
 */
class View
{
    /**
     * @param $route
     * Редирект
     */
    public function redirect($route)
    {
        header('Location: ' . WEB_ROOT . $route);
        die();
    }

    /**
     * @param $content_view
     * @param $template_view
     * @param null $data
     * Отображение view
     */
    public function render($content_view, $template_view, $data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        require_once(APP_ROOT . '/app/view/layout/' . $template_view . '.php');
    }
}

?>