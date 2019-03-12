<?php
  $db = new PDO('sqlite:places.db');

  // Drop tables if there are any
  $db->exec('DROP TABLE IF EXISTS place');
  $db->exec('DROP TABLE IF EXISTS tag');
  $db->exec('DROP TABLE IF EXISTS place_tag');

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
    FOREIGN KEY(place_id) REFERENCES place(id) ON DELETE CASCADE,
    FOREIGN KEY(tag_id) REFERENCES tag(id)
  )');

  $db->exec('INSERT INTO place (title, description, latitude, longitude, opens_at, closes_at)
  VALUES (
    "Stockmann",
    "Stockmann Helsinki Centre is a culturally significant business building and department store located in the centre of Helsinki, Finland.",
    60.1683,
    24.9422,
    time("09:00"),
    time("21:00")
  )');

  echo 'SUCCESS';
?>