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

  function check_duplicates($db, $data) {
    $query = 'SELECT place_id FROM place_tag WHERE place_id = :place_id AND tag_id = :tag_id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':place_id', $data->place_id, PDO::PARAM_INT);
    $stmt->bindParam(':tag_id', $data->tag_id, PDO::PARAM_INT);

    $stmt->execute();
    $result = $stmt->fetch();
    return !empty($result);
  }

  function create($db, $data) {
    if (check_duplicates($db, $data)) return show_error('Tag already exists');
    
    $query = 'INSERT INTO place_tag(place_id, tag_id) VALUES (:place_id, :tag_id)';

    $stmt = $db->prepare($query);

    $stmt->bindParam(':place_id', $data->place_id, PDO::PARAM_INT);
    $stmt->bindParam(':tag_id', $data->tag_id, PDO::PARAM_INT);

    $success = $stmt->execute();
    echo $success;
  }

  function remove() {
    $query = 'DELETE '
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') create($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') remove($db, $data);
?>