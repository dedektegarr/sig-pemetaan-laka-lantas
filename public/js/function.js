// KONFIGURASI MAPBOX
// Menampilkan Map
mapboxgl.accessToken = 'pk.eyJ1IjoiZGVkZWt0ZWdhciIsImEiOiJjbGVjdnJkY3cwMHl5M3BxanYwc2dueWNsIn0.nBiB8NlOPqhCxpnqgK4glA';
const setMap = ({ lng, lat, zoom, draggable }) => {
    $('#map').html('');
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lng, lat],
        zoom: zoom,
    });

    var marker = new mapboxgl.Marker({
        draggable
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
const newOptionElement = (parent, data, isSelected) => {
    const options = Array.isArray(data) ? data : [data];

    for (let data of options) {
        const newOption = document.createElement('option');

        if (data.id === isSelected) {
            newOption.selected = true;
        }

        newOption.value = data.id;
        newOption.innerText = data.nama;
        parent.append(newOption);
    }
}

// result element
const resultElement = (data) => {
    $('#results').html('');
    for (let value of data) {
        let subDisctrict = '';
        let district = '';
        let street = '';

        if (value.address.subdistrict) {
            const subDisctrictArr = value.address.subdistrict.split(' ');
            subDisctrict = ', ' + subDisctrictArr.slice(0, subDisctrictArr.length - 1).join(' ') + ',';
        }

        if (value.address.district) {
            district = value.address.district;
        }

        const newList = document.createElement('li');
        newList.classList.add('result-item');
        newList.setAttribute('data-coor', `${value.position.lng}, ${value.position.lat}`);
        newList.innerText = `${value.address.street}${subDisctrict} ${district}`;

        // if (value.address.street) {
        $('#results').append(newList);
        // }
    }
}
