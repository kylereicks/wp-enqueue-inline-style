<?php
if(!class_exists('View_WP_Enqueue_Inline_Style')){
  class View_WP_Enqueue_Inline_Style{

    public static function do_items($model){

      foreach($model->queue as $media => $styles){
        self::render_template('inline-style', array('media' => $media, 'styles' => $styles, 'model' => $model));
      }

    }

    public static function print_file_data($style, $model){
      $file = '';
      $site_url = get_site_url();
      $style_path = str_replace($site_url . '/', '', $model->registered[$style]['src']);

      if($style_path === $model->registered[$style]['src'] && 1 !== preg_match('/^\/[^\/]/', $style_path)){
        $file = $style_path;
      }else{
        $file = ABSPATH . $style_path;
      }

      echo file_get_contents($file);
    }

    private static function render_template($template, $template_data = array()){
      $template_path = apply_filters('wp_enqueue_inline_style_template_path', WP_ENQUEUE_INLINE_STYLE_PATH . 'inc/templates/');
      $template_file_path = apply_filters('wp_enqueue_inline_style_' . $template . '_template_file_path', $template_path . $template . '-template.php', $template, $template_path);
      $template_data = apply_filters('wp_wp_enqueue_inline_style_' . $template . '_template_data', $template_data);
      if(!empty($template_data)){
        extract($template_data);
      }
      ob_start();
      include($template_file_path);
      echo apply_filters('wp_enqueue_inline_style_' . $template . '_template', ob_get_clean());
    }
 
  }
}
