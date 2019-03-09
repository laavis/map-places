<?php
  require '../db/connect.php';

  // Set header
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: POST,GET,PUT,DELETE");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $data = json_decode(file_get_contents("php://input"));

  function show_error($error) {
    echo json_encode(array("error"=>$error));
  }

  function show_success($data = []) {
    echo json_encode(array_merge(array("success"=>true), $data));
  }

  
?>