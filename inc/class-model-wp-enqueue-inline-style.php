<?php
if(!class_exists('Model_WP_Enqueue_Inline_Style')){
  class Model_WP_Enqueue_Inline_Style{

    public $registered = array();
    public $done = array();
    public $queue = array();

    public function register_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all'){
      global $wp_styles;
      wp_register_style($handle, $src, $deps, $ver, $media);

      if(empty($src)){
        if(array_key_exists($handle, $wp_styles->registered)){
          $this->registered[$handle] = array(
            'handle' => $handle,
            'src' => $wp_styles->registered[$handle]['src'],
            'deps' => $wp_styles->registered[$handle]['deps'],
            'ver' => $wp_styles->registered[$handle]['ver'],
            'media' => $wp_styles->registered[$handle]['media']
          );

        }

      }else{
        if(!array_key_exists($handle, $this->registered)){
          $this->registered[$handle] = array(
            'handle' => $handle,
            'src' => $src,
            'deps' => $deps,
            'ver' => $ver,
            'media' => $media
          );
        }
      }
    }

    public function enqueue_inline_style($handle, $src = '', $deps = array(), $ver = false, $media = 'all'){
      if(!array_key_exists($handle, $this->registered)){
        $this->register_inline_style($handle, $src, $deps, $ver, $media);
      }

      $this->add_to_queue($handle);
    }

    public function all_deps(){
      global $wp_styles;
      $wp_styles->all_deps($wp_styles->queue);

      foreach($wp_styles->to_do as $style){
        if(array_key_exists($style, $this->registered)){
          $this->add_to_queue($style);
        }
        foreach($wp_styles->registered[$style]->deps as $dependency){
          if(array_key_exists($dependency, $this->registered)){
            $this->add_to_queue($dependency);
          }
        }
      }

      foreach($this->queue as $media => $styles){
        foreach($styles as $style){
          $this->dependency_check($style);
        }
      }

      foreach($this->queue as $media => $styles){
        usort($this->queue[$media], array($this, 'dependency_sort'));

        foreach($styles as $style){
          $wp_styles->queue = array_merge(array_diff($wp_styles->queue, array($style)));
          $wp_styles->done[] = $style;
        }
      }
    }

    private function dependency_check($style){
      if(!empty($this->registered[$style]['deps'])){
        foreach($this->registered[$style]['deps'] as $dependency){
          if(array_key_exists($dependency, $this->registered)){
            $this->add_to_queue($dependency);
            $this->dependency_check($dependency);
          }
        }
      }

    }

    private function dependency_sort($a, $b){
      if(in_array($a, $this->registered[$b]['deps'])){
        return -1;
      }else{
        return 1;
      }

    }

    private function add_to_queue($handle){
      if(!array_key_exists($this->registered[$handle]['media'], $this->queue)){
        $this->queue[$this->registered[$handle]['media']] = array($handle);
      }else{
        if(!in_array($handle, $this->queue[$this->registered[$handle]['media']])){
          $this->queue[$this->registered[$handle]['media']][] = $handle;
        }
      }
    }

  }
}
