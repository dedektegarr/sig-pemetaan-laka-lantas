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

const customMarker = data => {
    let markerBackground;
    if (data.meninggal) {
        markerBackground = '#E76161';
    } else if (data.luka_berat) {
        markerBackground = '#F79327';
    } else {
        markerBackground = '#19A7CE';
    }

    // Create a custom marker element
    const marker = document.createElement('div');
    marker.className = 'custom-marker';
    marker.style.backgroundColor = markerBackground;

    return marker;
}

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

        if (value.address.street) {
            $('#results').append(newList);
        }
    }
}

// SELECT2
const select2Init = (element, parent) => {
    $(element).select2({
        dropdownParent: parent
    });
}

// Isi Kecamatan jika ada didalam nama jalan
const fillKecKel = (kecamatan, kelurahan, result) => {
    for (let kec of kecamatan) {
        if (result.includes(kec.nama)) {
            const option = $('<option>').val(kec.id).text(kec.nama).attr('selected', true);
            $('#kecamatan').append(option);
        }
    }
    for (let kel of kelurahan) {
        if (result.includes(kel.nama)) {
            $('#kelurahan_desa').html('');
            const option = $('<option>').val(kel.id).text(kel.nama).attr('selcted', true);
            $('#kelurahan_desa').append(option);
        }
    }
}