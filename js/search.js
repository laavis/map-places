document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search');
  const searchBtn = document.getElementById('search-btn');

  searchBtn.addEventListener('click', e => {
    const searchValue = searchInput.value;
    e.preventDefault();
    clearMarkers();
    searchByTitle(searchValue);
  });
});

const searchByTitle = value => {
  data = {
    search_str: value
  };
  const settings = {
    body: JSON.stringify(data),
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  fetch('api/search.php', settings)
    .then(res => res.json())
    .then(results => {
      for (let result of results) {
        createMarker(result);
      }
    })
    .catch(console.error());
};
