<?php

function wp_register_inline_style($handle, $src, $deps = array(), $ver = false, $media = 'all'){
  WP_Enqueue_Inline_Style::get_instance()->register_inline_style($handle, $src, $deps, $ver, $media);
}

function wp_enqueue_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all'){
  WP_Enqueue_Inline_Style::get_instance()->enqueue_inline_style($handle, $src, $deps, $ver, $media);
}
