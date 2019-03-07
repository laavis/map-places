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
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div id="map" class="map"></div>
      <aside class="sidebar">
      <div class="search-container">
        <input class="search" type="search" placeholder="Search">
        <button>
          <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16zM21 21l-4.35-4.35" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
      </aside>
    </div>
  </div>
</body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3ciRt73Nu_ypk0bJUxzYjjPolyWm_7LY&callback=initMap"async defer></script>
</html>