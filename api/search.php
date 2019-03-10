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

  function search_by_title($db, $data) {
    $query = "SELECT
      id,
      title,
      description,
      latitude,
      longitude,
      opens_at,
      closes_at
    FROM place
    WHERE title LIKE :search_str";

    $title = "%$data->search_str%";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':search_str', $title, PDO::PARAM_STR);
    $success = $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') search_by_title($db, $data);
?>