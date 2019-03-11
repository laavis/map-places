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

  function check_duplicates($db, $data) {
    $query = 'SELECT place_id FROM place_tag WHERE place_id = :place_id AND tag_id = :tag_id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':place_id', $data->place_id, PDO::PARAM_INT);
    $stmt->bindParam(':tag_id', $data->tag_id, PDO::PARAM_INT);

    $stmt->execute();
    $result = $stmt->fetch();
    return !empty($result);
  }

  function tag_exists($db, $label) {
    $query = 'SELECT id FROM tag WHERE label = :label';

    $stmt = $db->prepare($query);
    $stmt->bindParam(':label', $label, PDO::PARAM_STR);

    $stmt->execute();
    $result = $stmt->fetch();

    if (empty($result) || !$result) return null;
    return $result['id'];
  }

  function create_tag($db, $label) {
    $query = "INSERT INTO tag (label) VALUES (:label)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':label', $label, PDO::PARAM_STR);

    $success = $stmt->execute();
    $tag_id = tag_exists($db, $label);
    return $tag_id;
  }

  function create($db, $data) {
    // $label = $data->label;
    $tag_id = tag_exists($db, $data->label);

    if ($tag_id == null) {
      $tag_id = create_tag($db, $data->label);
    }

    if (check_duplicates($db, $data)) return show_error('Tag already exists');
    
    $query = 'INSERT INTO place_tag(place_id, tag_id) VALUES (:place_id, :tag_id)';

    $stmt = $db->prepare($query);

    $stmt->bindParam(':place_id', $data->place_id, PDO::PARAM_INT);
    $stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);

    $success = $stmt->execute();
    show_success();
  }

  function remove() {
    $query = 'DELETE FROM place_tag WHERE id = :id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);

  
    $succes = $stmt->execute();
    echo 'tag removed';
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') create($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') remove($db, $data);
?>