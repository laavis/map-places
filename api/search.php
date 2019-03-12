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

  function search_by_title_or_tag($db, $data) {
    $query = 'SELECT
      p.id,
      p.title,
      p.description,
      p.latitude,
      p.longitude,
      p.opens_at,
      p.closes_at
      FROM place p
      LEFT JOIN place_tag pt ON p.id = pt.place_id
      LEFT JOIN tag t ON t.id = pt.tag_id
      WHERE t.label LIKE :search_tag OR p.title LIKE :search_title
      GROUP BY p.id';

      $tag = "%";
      if (!empty($data->search_tag)) {
        $tag = "%$data->search_tag%";
      }

      $title = "%";
      if (!empty($data->search_title)) {
        $title = "%$data->search_title%";
      }

      $stmt = $db->prepare($query);
      $stmt->bindParam(':search_tag', $tag, PDO::PARAM_STR);
      $stmt->bindParam(':search_title', $title, PDO::PARAM_STR);
      $success = $stmt->execute();

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($results);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') search_by_title_or_tag($db, $data);
?>