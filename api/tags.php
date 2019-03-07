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

  function create($db, $data) {
    $query = "INSERT INTO tag (label) VALUES (:label)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':label', $data->label, PDO::PARAM_STR);

    $succes = $stmt->execute();
    echo 'succ';
  }

  function read($db) {
    $query = 'SELECT id, label FROM tag';

    $results = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
  }

  function update($db, $data) {
    $query = "UPDATE tag SET label = :label WHERE id = :id";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':label', $data->label, PDO::PARAM_STR);
    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);

    $success = $stmt->execute();
    echo 'success';
  }

  function remove($db, $data) {
    $query = 'DELETE FROM tag WHERE id = :id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);

  
    $succes = $stmt->execute();
    echo 'tag removed';
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') create($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'GET') read($db);
  if ($_SERVER['REQUEST_METHOD'] === 'PUT') update($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') remove($db, $data);
?>