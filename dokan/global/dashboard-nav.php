<?php
$home_url = home_url();
$active_class = ' class="active"'
?>

<div class="o-page__aside">
    <div class="c-profile-aside">
        <div class="c-profile-menu">
            <div class="c-profile-menu__header">حساب کاربری شما</div>
            <?php
            global $allowedposttags;

            // These are required for the hamburger menu.
            if (is_array($allowedposttags)) {
                $allowedposttags['input'] = [
                    'id' => [],
                    'type' => [],
                    'checked' => []
                ];
            }

            echo wp_kses(dokan_dashboard_nav($active_menu), $allowedposttags);
            ?>
        </div>
    </div>
</div>
