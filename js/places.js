const data = {};

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form');
  const overlay = document.getElementById('overlay');
  const myPlacesBtn = document.getElementById('my-places-btn');

  getPlaces();

  myPlacesBtn.addEventListener('click', () => {
    overlay.classList.toggle('active');
  });

  form.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(form);
    formData.forEach((value, key) => {
      data[key] = value;
    });
    addPlace();
  });
});

const addPlace = () => {
  const settings = {
    body: JSON.stringify(data),
    method: 'post',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  fetch('api/places.php', settings)
    .then(res => {
      console.log(res.json());
      getPlaces();
    })
    .catch(console.error());
};

const createPlaceCard = places => {
  for (let place in places) {
    console.log(places);
    const placeContainer = document.createElement('div');
    placeContainer.classList.add('place-container');

    const title = document.createElement('h4');
    title.classList.add('title');
    title.innerHTML = places[place].title;

    const coordinates = document.createElement('p');
    coordinates.classList.add('coordinates');
    coordinates.innerHTML = `${places[place].latitude}, ${
      places[place].longitude
    }`;

    const openingHours = document.createElement('p');

    if (places[place].opens_at !== null && places[place].closes_at !== null) {
      openingHours.classList.add('opening-hours');
      openingHours.innerHTML = `${places[place].opens_at} - ${
        places[place].closes_at
      }`;
    }

    const description = document.createElement('p');
    description.classList.add('description');
    description.innerHTML = places[place].description;

    const editBtn = document.createElement('button');
    editBtn.classList.add('edit-btn');
    editBtn.innerHTML = 'Edit';

    placeContainer.appendChild(title);
    placeContainer.appendChild(coordinates);
    placeContainer.appendChild(openingHours);
    placeContainer.appendChild(description);
    placeContainer.appendChild(editBtn);
    overlay.appendChild(placeContainer);
  }
};

const getPlaces = () => {
  const settings = {
    method: 'get'
  };

  overlay.innerHTML = '';

  fetch('api/places.php', settings)
    .then(res => res.json())
    .then(places => {
      createPlaceCard(places);
    })
    .catch(console.error());
};
