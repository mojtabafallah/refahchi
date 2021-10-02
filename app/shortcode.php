<?php

namespace app;

class shortCode
{
    public static function register_form()
    {

        if (!is_user_logged_in()) {
            if (isset($_POST['register_user']))
            {
                wp_create_user($_POST['user_name'],$_POST['password']);

            }
            include "views/shortcode/register.php";
        } else {
            wp_redirect("/my-account");
        }

    }
}