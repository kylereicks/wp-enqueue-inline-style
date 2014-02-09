<?php
/*
Plugin Name: WP Enqueue Inline Style
Plugin URI:
Description: Add inline CSS to the head.
Author: Kyle Reicks
Version: 0.1.0
Author URI: http://github.com/kylereicks/
*/

define('WP_ENQUEUE_INLINE_STYLE_PATH', plugin_dir_path(__FILE__));
define('WP_ENQUEUE_INLINE_STYLE_URL', plugins_url('/', __FILE__));
define('WP_ENQUEUE_INLINE_STYLE_VERSION', '0.1.0');

require_once(WP_ENQUEUE_INLINE_STYLE_PATH . 'inc/class-wp-enqueue-inline-style.php');
require_once(WP_ENQUEUE_INLINE_STYLE_PATH . 'inc/functions-wp-enqueue-inline-style.php');

register_deactivation_hook(__FILE__, array('WP_Enqueue_Inline_Style', 'deactivate'));

add_action('plugins_loaded', array('WP_Enqueue_Inline_Style', 'get_instance'));
