<style media="<?php echo $media; ?>">
<?php
foreach($styles as $style){
  self::print_file_data($style, $model);
}
?>
</style>
