<?php

namespace config;

class view
{
    /**
     * Renderiza el HTML Final, se le puede pasar como segundo parametro un
     * Array Asociativo y convertira el Key del primer nivel como nombre de la variable a utilizar en el HTML
     * @param String $template_url
     * @param mixed array $parameters
     * @return void
     */
    public static function render(String $template_url, array $parameters)
    {
        foreach ($parameters as $property => $value) {
            $$property = $value;
        }


        if (!empty($parameters['get'])) {
            // echo 'Si tiene datos el get';
            // print_r($get);
            foreach ($get as $property => $value) {
                $$property = $value;
            }
        }
        if (!empty($parameters['post'])) {
            foreach ($post as $property => $value) {
                $$property = $value;
            }
        }
        require_once "./views/$template_url.php";
    }
    public static function renderElement(String $template_url, array $parameters = null)
    {
        if ($parameters !== null) {
            foreach ($parameters as $property => $value) {
                $$property = $value;
            }
        }
        if (!empty($parameters['get'])) {
            // echo 'Si tiene datos el get';
            // print_r($get);
            foreach ($get as $property => $value) {
                $$property = $value;
            }
        }
        if (!empty($parameters['post'])) {
            foreach ($post as $property => $value) {
                $$property = $value;
            }
        }
        require_once "./views/elements/$template_url.php";
    }
    public static function renderT(String $template_url, array $block, array $parameters)
    {
        foreach ($parameters as $property => $value) {
            $$property = $value;
        }
        if (!empty($parameters['get'])) {
            // echo 'Si tiene datos el get';
            // print_r($get);
            foreach ($get as $property => $value) {
                $$property = $value;
            }
        }
        if (!empty($parameters['post'])) {
            echo 'Si tiene datos el POST';
            foreach ($post as $property => $value) {
                $$property = $value;
            }
        }
        $block = $block;
        $view_name = TEMPLATE . $template_url . ".tpl.php";
        include($view_name);
    }
    public static function block($name)
    {
        return BLOCKS . $name . ".php";
    }
    public static function modal($name)
    {
        return MODALS . $name . ".php";
    }
    public static function contents($name)
    {
        return CONTENTS . $name . ".php";
    }
    public static function element($name)
    {
        return ELEMENTS . $name . ".php";
    }
}
