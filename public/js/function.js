// KONFIGURASI MAPBOX
// Menampilkan Map
mapboxgl.accessToken = 'pk.eyJ1IjoiZGVkZWt0ZWdhciIsImEiOiJjbGVjdnJkY3cwMHl5M3BxanYwc2dueWNsIn0.nBiB8NlOPqhCxpnqgK4glA';
const setMap = ({ lng, lat }) => {
    $('#map').html('');
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lng, lat],
        zoom: 12,
    });

    var marker = new mapboxgl.Marker({
        draggable: true
    })
        .setLngLat({ lng, lat })
        .addTo(map);

    marker.on('dragend', function () {
        const position = marker.getLngLat();
        $('#longitude').val(position.lng);
        $('#latitude').val(position.lat);
    });

    map.addControl(new mapboxgl.NavigationControl());
};

// ELEMENT
// option element
const newOptionElement = (parent, data) => {
    const options = Array.isArray(data) ? data : [data];

    for (let data of options) {
        const newOption = document.createElement('option');
        newOption.value = data.id;
        newOption.innerText = data.nama;
        parent.append(newOption);
    }
}

// result element
const resultElement = (data) => {
    $('#results').html('');
    for (let value of data) {
        const newList = document.createElement('li');
        newList.classList.add('result-item');
        newList.setAttribute('data-coor', `${value.position.lng}, ${value.position.lat}`);
        newList.innerText = `${value.address.street}, ${value.address.city}`;

        if (value.address.street) {
            $('#results').append(newList);
        }
    }
}
