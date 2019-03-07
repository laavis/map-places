<?php
  require_once "vendor/leafo/scssphp/scss.inc.php";
  use Leafo\ScssPhp\Compiler;
  $scss = new Compiler();
  $scss->setImportPaths('styles/');

  // echo $scss->compile('
  //   $color: #abc;
  //   div { color: lighten($color, 20%); }
  // ');
?>