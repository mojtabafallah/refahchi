<?php


namespace app;


class view
{
    public static function render_person($filename, $post = null)
    {

        include 'views' . DIRECTORY_SEPARATOR . $filename . '.php';
    }



    public static function render($filename, $post = null)
    {

        include 'views' . DIRECTORY_SEPARATOR . $filename . '.php';

    }

    public static function render_plans($filename)
    {



    }

}