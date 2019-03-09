const data = {};
let active = false;
let formState = 'add';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form');
  const overlay = document.getElementById('overlay');
  const myPlacesBtn = document.getElementById('my-places-btn');

  getPlaces();

  myPlacesBtn.addEventListener('click', () => {
    overlay.classList.toggle('active');
    if (active) {
      active = false;
      overlay.classList.add('hide');
      setTimeout(() => {
        overlay.classList.remove('hide');
      }, 250);
    } else {
      active = true;
    }
  });

  form.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(form);
    formData.forEach((value, key) => {
      data[key] = value;
    });
    console.log(form.action);
    if (formState === 'add') addPlace();
    editPlace();
  });
});

const addPlace = () => {
  const settings = {
    body: JSON.stringify(data),
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  fetch('api/places.php', settings)
    .then(res => {
      getPlaces();
    })
    .catch(console.error());
};

const editPlace = () => {
  const settings = {
    body: JSON.stringify(data),
    method: 'PUT',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  fetch('api/places.php', settings)
    .then(res => {
      console.log(res);
      getPlaces();
    })
    .catch(console.error());
};

const editPlaceUi = (id, title, description, lat, lng, opensAt, closesAt) => {
  formState = 'update';
  const formFunctionTitle = document.getElementById('form-function');
  const submitBtn = document.getElementById('submit-btn');
  const saveBtn = document.getElementById('save-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const sidebar = document.getElementById('sidebar');

  data.id = id;

  sidebar.style.backgroundColor = '#F47755';
  saveBtn.style.display = 'block';
  cancelBtn.style.display = 'block';
  submitBtn.style.display = 'none';
  formFunctionTitle.innerHTML = 'Edit Place';
  form.elements['latitude'].value = lat;
  form.elements['longitude'].value = lng;
  form.elements['title'].value = title;
  form.elements['description'].value = description;
  form.elements['opens_at'].value = opensAt;
  form.elements['closes_at'].value = closesAt;

  cancelBtn.addEventListener('click', e => {
    e.preventDefault();
    formState = 'add';
    sidebar.style.backgroundColor = '#2d7274';
    saveBtn.style.display = 'none';
    cancelBtn.style.display = 'none';
    submitBtn.style.display = 'block';
    formFunctionTitle.innerHTML = 'Add Place';
    form.reset();

    delete data.id;

    overlay.classList.remove('active');
    overlay.classList.add('hide');
    setTimeout(() => {
      overlay.classList.remove('hide');
    }, 250);
    active = false;
  });
};

const createPlaceCard = places => {
  for (let place in places) {
    const id = places[place].id;
    const title = places[place].title;
    const latitude = places[place].latitude;
    const longitude = places[place].longitude;
    const description = places[place].description;
    const opensAt = places[place].opens_at;
    const closesAt = places[place].closes_at;

    const placeContainer = document.createElement('div');
    placeContainer.classList.add('place-container');

    const titleElement = document.createElement('h4');
    titleElement.classList.add('title');
    titleElement.innerHTML = title;

    const coordinatesElement = document.createElement('p');
    coordinatesElement.classList.add('coordinates');
    coordinatesElement.innerHTML = `${latitude}, ${longitude}`;

    const openingHours = document.createElement('p');

    if (places[place].opens_at !== null && places[place].closes_at !== null) {
      openingHours.classList.add('opening-hours');
      openingHours.innerHTML = `${places[place].opens_at} - ${
        places[place].closes_at
      }`;
    }

    const descriptionElement = document.createElement('p');
    descriptionElement.classList.add('description');
    descriptionElement.innerHTML = description;

    const editBtn = document.createElement('button');
    editBtn.classList.add('edit-btn');
    editBtn.innerHTML = 'Edit';

    editBtn.addEventListener('click', () => {
      /*const input = document.createElement('textarea');
      input.value = descriptiotText;
      placeContainer.removeChild(descriptionElement);
      placeContainer.removeChild(editBtn);
      placeContainer.appendChild(input);*/
      editPlaceUi(
        id,
        title,
        description,
        latitude,
        longitude,
        opensAt,
        closesAt
      );
    });

    placeContainer.appendChild(titleElement);
    placeContainer.appendChild(coordinatesElement);
    placeContainer.appendChild(openingHours);
    placeContainer.appendChild(descriptionElement);
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
