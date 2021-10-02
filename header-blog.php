<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php the_title()?></title>
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/swiper_bundle.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/flickity.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/style.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/responsive.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/blog/simple-scrollbar.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/vendor/fontawesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/vendor/swiper/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/vendor/slicknav/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/main.css">
    <link rel="stylesheet" href="<?php echo URL_THEME ?>/assets/css/mediaq.css">
    <link rel="icon" href="<?php echo URL_THEME ?>/assets/images/fav.png" sizes="any" type="image/png">
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

                    <a href="my-account"> ورود به حساب کاربری </a>



                </div>
            </div>
            <div class="devider"></div>

            <a href="<?php echo site_url()?>/cart" class="cart">
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