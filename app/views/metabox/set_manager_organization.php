<div class="wrap">
    <?php $managers_organ = get_users(['role' => 'manager_organization']);
?>
    <select name="all_role_manager_organ" id="all_role_manager_organ" required>
        <option>یک مدیر انتخاب کنید</option>

        <?php foreach ($managers_organ as $manager): ?>
           <option value="<?php echo $manager->ID?>" <?php echo get_post_meta($post->ID,'id_manager_organization',true) == $manager->ID ? "selected" : "" ?>><?php echo $manager->user_login?></option>
        <?php endforeach; ?>

    </select>
</div>
