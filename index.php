<?php
  if (file_exists('./env.php')) {
    require './env.php';
  } else {
    $GOOGLE_MAPS_KEY = getenv('GOOGLE_MAPS_KEY');
  }
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
  <script src="js/tags.js"></script>
  <script src="js/places.js"></script>
  <script src="js/search.js"></script>
</head>
<body>
  <div class="wrapper">
    <div id="logo-container">
      <h1>Places </h1>
      <svg id="logo" width="20" height="28" viewBox="0 0 20 28" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 9.81818C20 17.4545 10 28 10 28C10 28 0 17.4545 0 9.81818C3.95203e-08 7.21424 1.05357 4.71695 2.92893 2.87568C4.8043 1.03441 7.34784 0 10 0C12.6522 0 15.1957 1.03441 17.0711 2.87568C18.9464 4.71695 20 7.21424 20 9.81818Z" fill="#FF582B"/>
        <path d="M10 15C12.7614 15 15 12.7614 15 10C15 7.23858 12.7614 5 10 5C7.23858 5 5 7.23858 5 10C5 12.7614 7.23858 15 10 15Z" fill="#80321D"/>
      </svg>
    </div>
    <div class="card">
      <div id="map" class="map"></div>
      <div id="overlay" class="saved-places-overlay"></div>
      <aside id="sidebar" class="sidebar">
        <div class="search-container">
          <input id="search" class="search" type="search" placeholder="Search by title or tag...">
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

            <label for="tags">Tags</label>
            <input id="tags" type="text" name="tags" placeholder="e.g restaurant, bar...">
            <div id="tags-container"></div>

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
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $GOOGLE_MAPS_KEY; ?>&callback=initMap"async defer></script>
</html>