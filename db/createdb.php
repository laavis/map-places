<?php
  require 'connect.php';

  // Drop tables if there are any
  $db->exec('DROP TABLE IF EXISTS place');
  $db->exec('DROP TABLE IF EXISTS tag');
  $db->exec('DROP TABLE IF EXISTS place_tag');

  echo 'OK';

  // Create tables
  $db->exec('CREATE TABLE place (
    id integer PRIMARY KEY NOT NULL,
    title varchar(255) NOT NULL,
    description text,
    latitude decimal(9,6) NOT NULL,
    longitude decimal(9,6) NOT NULL,
    opens_at integer,
    closes_at integer
    )');

  $db->exec('CREATE TABLE tag (
    id integer PRIMARY KEY NOT NULL,
    label varchar(255)
  )');

  $db->exec('CREATE TABLE place_tag (
    place_id INTEGER,
    tag_id INTEGER,
    FOREIGN KEY(place_id) REFERENCES place(id),
    FOREIGN KEY(tag_id) REFERENCES tag(id),
  )');

  $db->exec('INSERT INTO place (title, latitude, longitude, opens_at, closes_at) VALUES(
    "store",
    11,
    12,
    time("09:00"),
    time("21:00")
  )');

  $db->exec('INSERT INTO tag (label) VALUES (
    "asd"
  )');

    echo 'SUCCCESS';
?>