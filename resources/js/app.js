// Template Design
import "admin-lte";

// Library
import $ from "jquery";
import setMap from "./functions/map";
import mapboxgl from "mapbox-gl";
import initDatatables from "./functions/datatables";
import { initSelect2, enableSelect } from "./functions/select2";
import { newOptionElement, resultElement } from "./elements/elements";

// Ambil data Kota, Kecamatan, Kelurahan
const API = "http://localhost:8000/api";

// Set Map Pertama Kali Terbuka
$(document).ready(function () {
    // jika halaman terdapat element class "map-page"
    if ($('body').hasClass('map-page')) {
        setMap({
            lng: 102.263641,
            lat: -3.792228
        });

        // ambil data kecamatan pada saat pertama kali form input terbuka
        $.get(`${API}/kecamatan`, function (response) {
            newOptionElement($('#kecamatan'), response.kecamatan);
        });
    }

    // inisialisasi library select2 dan datatables
    initSelect2();
    initDatatables();

    // tutup element result ketika klik window
    $(window).on('click', () => $('#results').css('display', 'none'));
});

// Geocoding
$('#nama_jalan').on('input', function () {
    $('#results').css('display', 'none');
    if (this.value) {
        $('#results').css('display', 'block');
        $.get(`https://api.mapbox.com/geocoding/v5/mapbox.places/${this.value}.json?access_token=${mapboxgl.accessToken}`,
            function (response) {
                resultElement(response.features);
                // console.log(response.features);
            });
    }
});

// Ambil data api ketika result di klik
$('#results').on('click', function (e) {
    $('#nama_jalan').val(e.target.innerText);
    $('#results').css('display', 'none');
    const getPosition = e.target.getAttribute('data-coor').split(',');
    const position = {
        lng: getPosition[0],
        lat: getPosition[1]
    };

    $('#longitude').val(position.lng);
    $('#latitude').val(position.lat);

    setMap(position);
});

$('#kecamatan').on('select2:select', function (e) {
    const id = e.params.data.id;
    enableSelect($('#kelurahan_desa'), id);
    if (id) {
        $.get(`${API}/kelurahan?id_kecamatan=${id}`, function (response) {
            newOptionElement($('#kelurahan_desa'), response.kelurahan);
        });
    }
});

$('#kelurahan_desa').on('select2:select', function (e) {
    const id = e.params.data.id;
    enableSelect($('#nama_jalan'), id);
});