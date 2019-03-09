<?php
  require 'style.php';
?>
<!DOCTYPE <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>My Places</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="styles/main.css">
  <script src="js/map.js"></script>
  <script src="js/places.js"></script>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div id="map" class="map"></div>
      <div id="overlay" class="saved-places-overlay"></div>
      <aside id="sidebar" class="sidebar">
        <div class="search-container">
          <input class="search" type="search" placeholder="Search">
          <button id="search-btn">
            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM21 21l-4.35-4.35" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>
        <div class="form-container">
          <form id="form">
            <h4 id="form-function">Add Place</h4>
            <p>Type the coordinates or click on the map</p>

            <label for="latitude">Latitude</label>
            <input id="latitude" type="text" name="latitude" required>

            <label for="longitude">Longitude</label>
            <input id="longitude" type="text" name="longitude" required>

            <label for="title">Title</label>
            <input id="title" type="text" name="title" required>

            <label for="description">Description</label>
            <textarea id="description" type="text" name="description"></textarea>

            <div class="opening-hours">
              <div class="container">
                <label for="opens_at">Opens At</label>
                <input id="opens_at" type="text" name="opens_at" placeholder="08:00">
              </div>

              <div class="container">
                <label for="closes_at">Closes At</label>
                <input id="closes_at" type="text" name="closes_at" placeholder="21:00">
              </div>
            </div>

            <button id="submit-btn" type="submit" name="action" value="add">Add</button>
            <button id="save-btn" type="submit" name="action" value="update">Save</button>
            <button id="cancel-btn">Cancel</button>
          </form>
        </div>
        <button id="my-places-btn">My Places</button>
      </aside>
    </div>
  </div>
</body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3ciRt73Nu_ypk0bJUxzYjjPolyWm_7LY&callback=initMap"async defer></script>
</html>