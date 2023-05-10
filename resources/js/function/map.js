import $ from "jquery";
import mapboxgl from 'mapbox-gl';

mapboxgl.accessToken = 'pk.eyJ1IjoiZGVkZWt0ZWdhciIsImEiOiJjbGVjdnJkY3cwMHl5M3BxanYwc2dueWNsIn0.nBiB8NlOPqhCxpnqgK4glA';

const setMap = ({ lng, lat }) => {
    $('#map').html('');
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [lng, lat],
        zoom: 13,
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

export default setMap;