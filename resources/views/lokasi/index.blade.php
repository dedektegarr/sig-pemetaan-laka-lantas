@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
        type="text/css">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Lokasi</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kota_kabupaten">Kota / Kabupaten</label>
                            <select class="form-control select2" name="kota_kabupaten" id="kota_kabupaten">
                                <option value="">Pilih Kota / Kabupaten</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select class="form-control select2" name="kecamatan" id="kecamatan" disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelurahan_desa">Kelurahan / Desa</label>
                            <select class="form-control select2" name="kelurahan_desa" id="kelurahan_desa" disabled>
                                <option value="">Pilih Kelurahan / Desa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Koordinat</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" class="form-control form-control-sm" placeholder="latitude"
                                    autocomplete="off" name="latitude" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" class="form-control form-control-sm" placeholder="longitude"
                                    name="longitude" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div id='map' style='height: 350px;'></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- SELECT2 PLUGIN --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>

    <script>
        // Inisialisasi Select2
        $(document).ready(function() {
            const data = ['test', 'dasfd', 'asdf'];
            $('.select2').select2();
        });

        // Create Option Element Function
        const newOptionElement = (parent, data) => {
            const options = Array.isArray(data) ? data : [data];

            for (let data of options) {
                const newOption = document.createElement('option');
                newOption.value = data.id;
                newOption.innerText = data.nama;
                parent.append(newOption);
            }
        }

        // enamble element select
        const enableSelect = (element, isDisable) => {
            if (isDisable) {
                element.removeAttr('disabled');
            } else {
                element.attr('disabled', true);
            }
        }

        // API Wilayah Indonesia
        // Base API
        const API = "https://dev.farizdotid.com/api/daerahindonesia";
        // Mapbox TOKEN
        mapboxgl.accessToken =
            'pk.eyJ1IjoiZGVkZWt0ZWdhciIsImEiOiJjbGVjdnJkY3cwMHl5M3BxanYwc2dueWNsIn0.nBiB8NlOPqhCxpnqgK4glA';

        $.get(`${API}/kota/1771`, function(response) {
            newOptionElement($('#kota_kabupaten'), response);
        });

        $('#kota_kabupaten').on('select2:select', function(e) {
            const id = e.params.data.id;
            enableSelect($('#kecamatan'), id);
            if (id) {
                $.get(`${API}/kecamatan?id_kota=${id}`, function(response) {
                    newOptionElement($('#kecamatan'), response.kecamatan);
                });
            }
        });

        $('#kecamatan').on('select2:select', function(e) {
            const id = e.params.data.id;
            enableSelect($('#kelurahan_desa'), id);
            if (id) {
                $.get(`${API}/kelurahan?id_kecamatan=${id}`, function(response) {
                    newOptionElement($('#kelurahan_desa'), response.kelurahan);
                });
            }
        });

        $('#kelurahan_desa').on('select2:select', function(e) {
            const id = e.params.data.id;
            enableSelect($('#nama_jalan'), id);
        });

        $('#nama_jalan').on('select2:selecting select2:typing', function(e) {
            const inputValue = e.params.args.data.text;
            console.log('Data yang diketik:', inputValue);
        });


        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [102.2727, -3.8004], // starting position [lng, lat]
            zoom: 10, // starting zoom
        });

        map.addControl(
            new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            })
        );
        map.addControl(new mapboxgl.NavigationControl());
    </script>
@endsection
