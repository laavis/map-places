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

  function check_errors($data) {
    if (!isset($data->title) || empty($data->title)) return show_error('Title is required');
    if (!isset($data->latitude) || empty($data->latitude)) return show_error('Latitude is required');
    if (!isset($data->longitude) || empty($data->longitude)) return show_error('Longitude is required');
  }

  function read($db) {
    $query = "SELECT
      id,
      title,
      description,
      latitude,
      longitude,
      opens_at,
      closes_at
    FROM place";

    // Return an array indexed by column name
    $results = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
  }

  function create($db, $data) {
    // Check if required data is received
    check_errors($data);

    // Prepare INSERT statement (prevent sql injections)
    $query = "INSERT INTO place (
      title,
      description,
      latitude,
      longitude,
      opens_at,
      closes_at
    ) VALUES (
      :title,
      :description,
      :latitude,
      :longitude,
      time(:opens_at),
      time(:closes_at)
    )";

    $stmt = $db->prepare($query);

    // Bind parametres to statement variables
    $stmt->bindParam(':title', $data->title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $data->description, PDO::PARAM_STR);
    $stmt->bindParam(':latitude', $data->latitude, PDO::PARAM_STR);
    $stmt->bindParam(':longitude', $data->longitude, PDO::PARAM_STR);
    $stmt->bindParam(':opens_at', $data->opens_at, PDO::PARAM_STR);
    $stmt->bindParam(':closes_at', $data->closes_at, PDO::PARAM_STR);

    $success = $stmt->execute();
    echo 'success';
  }


  function update($db, $data) {
    // Check if required data is received
    check_errors($data);

    $query = "UPDATE place SET
      title = :title,
      description = :description,
      latitude = :latitude,
      longitude = :longitude,
      opens_at = :opens_at,
      closes_at = :closes_at
     WHERE
      id = :id
    ";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':title', $data->title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $data->description, PDO::PARAM_STR);
    $stmt->bindParam(':latitude', $data->latitude, PDO::PARAM_STR);
    $stmt->bindParam(':longitude', $data->longitude, PDO::PARAM_STR);
    $stmt->bindParam(':opens_at', $data->opens_at, PDO::PARAM_STR);
    $stmt->bindParam(':closes_at', $data->closes_at, PDO::PARAM_STR);
    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);

    
    $success = $stmt->execute();
    echo 'place updated';
  }

  function remove($db, $data) {
    $query = 'DELETE FROM place WHERE id = :id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);

    $success = $stmt->execute();
    echo 'post deleted';
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') create($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'GET') read($db);
  if ($_SERVER['REQUEST_METHOD'] === 'PUT') update($db, $data);
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') remove($db, $data);
?>