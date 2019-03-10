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

  $db->exec('INSERT INTO place (title, description, latitude, longitude, opens_at, closes_at)
  VALUES (
    "Kiasma",
    "Contemporary art museum & cultural center with thematic annual exhibitions, a theater and event",
    60.1720,
    24.9367,
    time("10:00"),
    time("20:30")
  )');

  $db->exec('INSERT INTO place (title, description, latitude, longitude, opens_at, closes_at)
  VALUES (
    "Design Museum Helsinki",
    "Long-standing design museum with an extensive permanent collection, plus a cafe & gift shop",
    60.1631,
    24.9467,
    time("11:00"),
    time("18:00")
  )');

  $db->exec('INSERT INTO tag (label) VALUES (
    "asd"
  )');

    echo 'SUCCCESS';
?>