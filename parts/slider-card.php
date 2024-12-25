<?php
$post_id = isset($args['post_id']) ? $args['post_id'] : get_the_ID();

$image = get_the_post_thumbnail($post_id, 'slider_thumbnail', ['class' => 'slider-image-thumb']);
$title = get_the_title($post_id);
?>
<li class="swiper-slide" data-id="<?= $post_id; ?>">
  <a href="#slider-popup" class="open-popup-link">
    <div class="slider-image" style="background: url('<?= get_image('placeholders/slider-placeholder.webp') ?>')  no-repeat center / cover">
      <div class="slider-image-overlay"></div>
      <?php echo $image; ?>
    </div>
    <h3 class="slider-title"><?php echo esc_html($title); ?></h3>
  </a>
</li>