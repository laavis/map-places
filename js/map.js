function initMap() {
  const helsinki = { lat: 60.1699, lng: 24.9384 };
  const map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: helsinki,
    styles: [
      {
        featureType: 'administrative',
        elementType: 'labels.text.fill',
        stylers: [
          {
            color: '#6195a0'
          }
        ]
      },
      {
        featureType: 'administrative.province',
        elementType: 'geometry.stroke',
        stylers: [
          {
            visibility: 'off'
          }
        ]
      },
      {
        featureType: 'landscape',
        elementType: 'geometry',
        stylers: [
          {
            lightness: '0'
          },
          {
            saturation: '0'
          },
          {
            color: '#f5f5f2'
          },
          {
            gamma: '1'
          }
        ]
      },
      {
        featureType: 'landscape.man_made',
        elementType: 'all',
        stylers: [
          {
            lightness: '-3'
          },
          {
            gamma: '1.00'
          }
        ]
      },
      {
        featureType: 'landscape.natural.terrain',
        elementType: 'all',
        stylers: [
          {
            visibility: 'off'
          }
        ]
      },
      {
        featureType: 'poi',
        elementType: 'all',
        stylers: [
          {
            visibility: 'on'
          }
        ]
      },
      {
        featureType: 'poi.park',
        elementType: 'geometry.fill',
        stylers: [
          {
            color: '#bae5ce'
          },
          {
            visibility: 'on'
          }
        ]
      },
      {
        featureType: 'road',
        elementType: 'all',
        stylers: [
          {
            saturation: -100
          },
          {
            lightness: 45
          },
          {
            visibility: 'simplified'
          }
        ]
      },
      {
        featureType: 'road.highway',
        elementType: 'all',
        stylers: [
          {
            visibility: 'simplified'
          }
        ]
      },
      {
        featureType: 'road.highway',
        elementType: 'geometry.fill',
        stylers: [
          {
            color: '#fac9a9'
          },
          {
            visibility: 'simplified'
          }
        ]
      },
      {
        featureType: 'road.highway',
        elementType: 'labels.text',
        stylers: [
          {
            color: '#4e4e4e'
          }
        ]
      },
      {
        featureType: 'road.arterial',
        elementType: 'labels.text.fill',
        stylers: [
          {
            color: '#787878'
          }
        ]
      },
      {
        featureType: 'road.arterial',
        elementType: 'labels.icon',
        stylers: [
          {
            visibility: 'off'
          }
        ]
      },
      {
        featureType: 'transit',
        elementType: 'all',
        stylers: [
          {
            visibility: 'simplified'
          }
        ]
      },
      {
        featureType: 'transit.station.airport',
        elementType: 'labels.icon',
        stylers: [
          {
            hue: '#0a00ff'
          },
          {
            saturation: '-77'
          },
          {
            gamma: '0.57'
          },
          {
            lightness: '0'
          }
        ]
      },
      {
        featureType: 'transit.station.rail',
        elementType: 'labels.text.fill',
        stylers: [
          {
            color: '#43321e'
          }
        ]
      },
      {
        featureType: 'transit.station.rail',
        elementType: 'labels.icon',
        stylers: [
          {
            hue: '#ff6c00'
          },
          {
            lightness: '4'
          },
          {
            gamma: '0.75'
          },
          {
            saturation: '-68'
          }
        ]
      },
      {
        featureType: 'water',
        elementType: 'all',
        stylers: [
          {
            color: '#eaf6f8'
          },
          {
            visibility: 'on'
          }
        ]
      },
      {
        featureType: 'water',
        elementType: 'geometry.fill',
        stylers: [
          {
            color: '#c7eced'
          }
        ]
      },
      {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [
          {
            lightness: '-49'
          },
          {
            saturation: '-53'
          },
          {
            gamma: '0.79'
          }
        ]
      }
    ]
  });

  const marker = new google.maps.Marker({
    position: helsinki,
    map: map,
    title: 'Click to zoom'
  });

  map.addListener('click', e => {
    setCoordinates(e, map);
    getCoordinates(e);
  });

  marker.addListener('click', () => {
    map.setZoom(8);
    map.setCenter(marker.getPosition());
  });
}

const getCoordinates = e => {
  let coordinates = [];
  let latitude = e.latLng.lat();
  let longitude = e.latLng.lng();
  coordinates.push(latitude, longitude);
  console.log(coordinates);
};

const setCoordinates = (e, map) => {
  let latitude = e.latLng.lat();
  let longitude = e.latLng.lng();
  console.log(latitude + ' ' + longitude);

  radius = new google.maps.Circle({
    map: map,
    radius: 100,
    fillColor: '#777',
    fillOpacity: 0.1,
    strokeColor: '#AA0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    draggable: true, // Dragable
    editable: true // Resizable
  });

  // Center of map
  map.panTo(new google.maps.LatLng(latitude, longitude));
};
