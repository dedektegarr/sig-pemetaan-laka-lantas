// Template Design
import "admin-lte";

// Library
import $ from "jquery";
import setMap from "./functions/map";
import { initSelect2, enableSelect } from "./functions/select2";
import mapboxgl from "mapbox-gl";
import { newOptionElement, resultElement } from "./elements/elements";

// Set Map Pertama Kali Terbuka
$(document).ready(function () {
    setMap({
        lng: 102.263641,
        lat: -3.792228
    });

    // inisialisasi library select2
    initSelect2();
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

// Ambil data Kota, Kecamatan, Kelurahan
const API = "https://dev.farizdotid.com/api/daerahindonesia";

$.get(`${API}/kota/1771`, function (response) {
    newOptionElement($('#kota_kabupaten'), response);
});

$('#kota_kabupaten').on('select2:select', function (e) {
    const id = e.params.data.id;
    enableSelect($('#kecamatan'), id);
    if (id) {
        $.get(`${API}/kecamatan?id_kota=${id}`, function (response) {
            newOptionElement($('#kecamatan'), response.kecamatan);
        });
    }
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