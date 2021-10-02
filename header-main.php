<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo URL_THEME ?>/assets/images/fav.png" sizes="any" type="image/png">
    <?php wp_head(); ?>

</head>
<body>
<header>
    <section class="top-head container">
        <div class="right-head">
            <div class="logo">
                <a href="<?php echo get_site_url() ?>">
                    <img src="<?php echo get_option("logo_site") ?>">
                </a>
            </div>
            <form role="search" action="">
                <button type="submit"><i class="fa fa-search"></i></button>
                <input name="s" type="text" placeholder="جستجو در <?php echo get_bloginfo( 'name' );?> ...">
            </form>


        </div>
        <div class="left-head">
            <div class="login-box">
                <div class="log-reg" id="logreg">
                    <i class="fa fa-user"></i>

                    <a href="<?php echo wc_get_account_endpoint_url('dashboard')?>"> ورود به حساب کاربری </a>



                </div>
            </div>
            <div class="devider"></div>

            <a href="<?php echo wc_get_cart_url()?>" class="cart">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>


    </section>


    <?php wp_nav_menu([
        'container_class'=>'top-nav container',
        'menu_class'=>'dropdown',
        'menu_id'=>'mynavmenu',
        'theme_location'=>"main_menu",
        "container"=>"nav",

        'walker'=>new My_Walker_Nav_Menu()
    ])?>




</header>