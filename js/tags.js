let tags = [];

const addTagsToUi = () => {
  const tagInput = document.getElementById('tags');

  tagInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      e.stopPropagation();

      const value = tagInput.value;

      if (tags.includes(value)) {
        tagInput.value = '';
        return;
      }

      const valueLowerCase = value.toLowerCase();
      tags.push(valueLowerCase);

      createTagUi(value);

      if (data.id) {
        addTag(data.id, valueLowerCase);
      }

      tagInput.value = '';
    }
  });
};

const addTag = (placeId, label) => {
  const settings = {
    body: JSON.stringify({
      place_id: placeId,
      label
    }),
    method: 'POST',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  return fetch('api/tags.php', settings);
};

const removeTag = (placeId, label) => {
  const settings = {
    body: JSON.stringify({
      place_id: placeId,
      label
    }),
    method: 'DELETE',
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  };

  return fetch('api/tags.php', settings);
};

const resetTagsUi = () => {
  const tagsContainer = document.getElementById('tags-container');
  tagsContainer.innerHTML = '';
};

const createTagUi = value => {
  const tagsContainer = document.getElementById('tags-container');
  const tagElement = document.createElement('div');
  tagElement.classList.add('tag-element');

  const removeTagBtn = document.createElement('div');
  removeTagBtn.classList.add('remove-tag-btn');

  removeTagBtn.addEventListener('click', e => {
    e.preventDefault();
    if (data.id) {
      removeTag(data.id, value);
    }
    tagElement.remove();
    const index = tags.indexOf(value);
    tags.splice(index, 1);
  });

  const tagValue = document.createElement('p');
  tagValue.innerText = value.toLowerCase();

  tagElement.appendChild(tagValue);
  tagElement.appendChild(removeTagBtn);
  tagsContainer.appendChild(tagElement);
};
