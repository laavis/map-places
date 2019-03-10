let data = {};
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
    if (formState === 'add') {
      addPlace();
      // Add marker to created place
      renderNewMarker(data);
    } else if (formState === 'update') {
      editPlace();
      clearMarkers();
      deleteMarkers();
      renderNewMarker(data);

      const submitBtn = document.getElementById('submit-btn');
      const saveBtn = document.getElementById('save-btn');
      const cancelBtn = document.getElementById('cancel-btn');
      const sidebar = document.getElementById('sidebar');

      sidebar.classList.toggle('edit');
      saveBtn.style.display = 'none';
      cancelBtn.style.display = 'none';
      submitBtn.style.display = 'block';

      overlay.classList.remove('active');
      overlay.classList.add('hide');
      setTimeout(() => {
        overlay.classList.remove('hide');
      }, 250);
      active = false;
      form.reset();
    }
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
      getPlaces();
    })
    .catch(console.error());
};

const deletePlace = id => {
  data = {
    id: id
  };

  const settings = {
    body: JSON.stringify(data),
    method: 'DELETE'
  };

  fetch('api/places.php', settings)
    .then(res => {
      getPlaces();
    })
    .catch(console.error());
  clearMarkers();
  deleteMarkers();
  setMapOnAll(window.map);
};

const editPlaceUi = place => {
  formState = 'update';
  const formFunctionTitle = document.getElementById('form-function');
  const submitBtn = document.getElementById('submit-btn');
  const saveBtn = document.getElementById('save-btn');
  const cancelBtn = document.getElementById('cancel-btn');
  const sidebar = document.getElementById('sidebar');

  data.id = place.id;

  sidebar.classList.add('edit');
  saveBtn.style.display = 'block';
  cancelBtn.style.display = 'block';
  submitBtn.style.display = 'none';
  formFunctionTitle.innerHTML = 'Edit Place';

  form.elements['latitude'].value = place.latitude;
  form.elements['longitude'].value = place.longitude;
  form.elements['title'].value = place.title;
  form.elements['description'].value = place.description;
  form.elements['opens_at'].value = place.opens_at;
  form.elements['closes_at'].value = place.closes_at;

  cancelBtn.addEventListener('click', e => {
    e.preventDefault();
    formState = 'add';
    sidebar.classList.remove('edit');
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
  for (let place of places) {
    const {
      id,
      title,
      latitude,
      longitude,
      description,
      opens_at,
      closes_at
    } = place;

    const placeContainer = document.createElement('div');
    placeContainer.classList.add('place-container');

    const deleteBtn = document.createElement('div');
    deleteBtn.classList.add('delete-place-btn');

    const trash = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    trash.setAttribute('width', '24');
    trash.setAttribute('height', '24');
    trash.setAttribute('viewBox', '0 0 24 24');

    const titleElement = document.createElement('h4');
    titleElement.classList.add('title');
    titleElement.innerHTML = title;

    const lid = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    lid.classList.add('lid');
    lid.setAttribute(
      'd',
      'M10 6.5C10 6.22386 10.2239 6 10.5 6H13.5C13.7761 6 14 6.22386 14 6.5V7.5H10V6.5ZM9 7.5V6.5C9 5.67157 9.67157 5 10.5 5H13.5C14.3284 5 15 5.67157 15 6.5V7.5H18.5V8.5H5.5V7.5H9Z'
    );

    const can = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    can.setAttribute(
      'd',
      'M7 8.5V18C7 18.8284 7.67157 19.5 8.5 19.5H15.5C16.3284 19.5 17 18.8284 17 18V8.5H16V18C16 18.2761 15.7761 18.5 15.5 18.5H8.5C8.22386 18.5 8 18.2761 8 18V8.5H7ZM10 11.5V15.5H11V11.5H10ZM13 11.5V15.5H14V11.5H13Z'
    );

    trash.appendChild(lid);
    trash.appendChild(can);
    deleteBtn.appendChild(trash);

    const coordinatesElement = document.createElement('div');
    coordinatesElement.classList.add('coordinates');
    //coordinatesElement.innerHTML = `${latitude}, ${longitude}`;
    const latitudeElement = document.createElement('p');
    latitudeElement.innerHTML = `<b>Latitude:</b> ${latitude}`;
    const longitudeElement = document.createElement('p');
    longitudeElement.innerHTML = `<b>Longitude:</b> ${longitude}`;

    coordinatesElement.appendChild(latitudeElement);
    coordinatesElement.appendChild(longitudeElement);

    const openingHours = document.createElement('p');

    if (opens_at !== null && closes_at !== null) {
      openingHours.classList.add('opening-hours');
      openingHours.innerHTML = `${opens_at} - ${closes_at}`;
    }

    const descriptionElement = document.createElement('p');
    descriptionElement.classList.add('description');
    descriptionElement.innerHTML = description;

    const editBtn = document.createElement('button');
    editBtn.classList.add('edit-btn');
    editBtn.innerHTML = 'Edit';

    editBtn.addEventListener('click', () => {
      editPlaceUi(place);
    });

    deleteBtn.addEventListener('click', e => {
      e.preventDefault();
      deletePlace(id);
    });

    placeContainer.appendChild(titleElement);
    placeContainer.appendChild(deleteBtn);
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
