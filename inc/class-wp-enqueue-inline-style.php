<?php
if(!class_exists('WP_Enqueue_Inline_Style')){
  class WP_Enqueue_Inline_Style{

    private $model;

    // Setup singleton pattern
    public static function get_instance(){
      static $instance;

      if(null === $instance){
        $instance = new self();
      }

      return $instance;
    }

    private function __clone(){
      return null;
    }

    private function __wakeup(){
      return null;
    }

    public static function deactivate(){
      self::clear_options();
    }

    private static function clear_options(){
      global $wpdb;
      $options = $wpdb->get_col('SELECT option_name FROM ' . $wpdb->options . ' WHERE option_name LIKE \'%wp_enqueue_inline_style%\'');
      foreach($options as $option){
        delete_option($option);
      }
    }

    private function __construct(){
      require_once(WP_ENQUEUE_INLINE_STYLE_PATH . 'inc/class-model-wp-enqueue-inline-style.php');

      $this->model = new Model_WP_Enqueue_Inline_Style();

      add_action('init', array($this, 'add_update_hook'));
      add_action('wp_print_styles', array($this, 'print_inline_styles'));
    }

    public function add_update_hook(){
      if(get_option('wp_enqueue_inline_style_version') !== WP_ENQUEUE_INLINE_STYLE_VERSION){
        update_option('wp_enqueue_inline_style_update_timestamp', time());
        update_option('wp_enqueue_inline_style_version', WP_ENQUEUE_INLINE_STYLE_VERSION);
        do_action('wp_enqueue_inline_style_updated');
      }
    }

    public function register_inline_style($handle, $src, $deps = array(), $ver = false, $media = 'all'){
      $this->model->register_inline_style($handle, $src, $deps, $ver, $media);
    }

    public function enqueue_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all'){
      $this->model->enqueue_inline_style($handle, $src, $deps, $ver, $media);
    }

    public function print_inline_styles(){
      require_once(WP_ENQUEUE_INLINE_STYLE_PATH . 'inc/class-view-wp-enqueue-inline-style.php');

      $this->model->all_deps();

      View_WP_Enqueue_Inline_Style::do_items($this->model);
    }

  }
}
