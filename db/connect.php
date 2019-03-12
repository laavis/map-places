<?php
  try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/places.db');
     // Set errormode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
?>