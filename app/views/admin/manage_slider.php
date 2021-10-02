<?php

$banners = get_posts(array(
    'post_type'=> ["post","product","page"],
    'meta_key' => 'enable_banner',
    'meta_value' => 'on',
));


$sliders = get_posts(array(
    'post_type'=> ["post","product","page"],
    'meta_key' => 'enable_slider',
    'meta_value' => 'on',
));

?>
<div class="wrap">
    <h1>مدیریت بنرها</h1>

    <table class="widefat">
        <thead>
        <tr>
            <th>شناسه لینک شده</th>
            <th>لینک</th>
            <th>عنوان</th>
            <th>تصویر</th>
            <th>موقعیت</th>
        </tr>
        <tbody>

        <?php foreach ($banners as $banner):  ?>
          <tr>
              <td>
                  <?php echo $banner->ID;?>
              </td>
              <td>
                  <a href="<?php echo get_permalink($banner->ID); ?>">لینک</a>
              </td>
              <td>
                  <?php echo $banner->post_title?>

              </td>
              <td>
                  <?php $img=get_post_meta($banner->ID,"image_slider_banner",true);?>
                  <img width="150px" src="<?php echo $img?>" alt="">

              </td>
              <td>
                  <?php


                  $position= get_post_meta($banner->ID,"position_banner",true);
                  switch ($position)
                  {
                      case 1:
                          echo "بالا کنار اسلایدر 1";
                          break;
                      case 2:
                          echo "بالا کنار اسلایدر 2";
                          break;
                      case 3:
                          echo "قسمت اول (1)";
                          break;
                      case 4:
                          echo "قسمت اول (2)";
                          break;
                      case 5:
                          echo "قسمت اول (3)";
                          break;
                      case 6:
                          echo "قسمت اول (4)";
                          break;
                      case 7:
                          echo "قسمت دوم (1)";
                          break;
                      case 8:
                          echo "قسمت دوم (2)";
                          break;
                      case 9:
                          echo "قسمت دوم (3)";
                          break;
                      case 10:
                          echo "قسمت دوم (4)";
                          break;
                      case 11:
                          echo "قسمت سوم";
                          break;
                      case 12:
                          echo "قسمت چهارم (1)";
                          break;
                      case 13:
                          echo "قسمت چهارم (12)";
                          break;

                  }

                  ?>
              </td>
          </tr>
        <?php endforeach; ?>
        </tbody>

        </thead>
    </table>

</div>

<div class="wrap">
    <h1>مدیریت اسلایدر </h1>

    <table class="widefat">
        <thead>
        <tr>
            <th>شناسه لینک شده</th>
            <th>لینک</th>
            <th>عنوان</th>
            <th>تصویر</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($sliders as $slider):  ?>
            <tr>
                <td>
                    <?php echo $slider->ID;?>
                </td>
                <td>
                    <a href="<?php echo get_permalink($slider->ID); ?>">لینک</a>
                </td>
                <td>
                    <?php echo $slider->post_title?>

                </td>
                <td>
                    <?php $img=get_post_meta($slider->ID,"image_slider_banner",true);?>
                    <img width="150px" src="<?php echo $img?>" alt="">

                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>