document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('search');
  const searchBtn = document.getElementById('search-btn');

  searchBtn.addEventListener('click', e => {
    const searchValue = searchInput.value;
    e.preventDefault();
    clearMarkers();
    searchByTitle(searchValue, searchValue);
  });
});

const searchByTitle = (tag, title) => {
  const settings = {
    body: JSON.stringify({
      search_tag: tag,
      search_title: title
    }),
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
