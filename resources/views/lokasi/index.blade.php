@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css"
        type="text/css">

    <style>
        .form-autocomplete {
            position: relative;
        }

        .result {
            background-color: salmon;
            width: 100%;
            list-style: none;
            position: absolute;
            z-index: 10;
            display: none;
        }

        .result .result-item {
            padding: .5em 1em;
            border-bottom: 1px solid rgba(0, 0, 0, 0.301);
            display: block;
            cursor: pointer;
        }
    </style>
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
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="longitude"
                                        name="longitude" autocomplete="off" readonly id="longitude">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="latitude"
                                        autocomplete="off" name="latitude" readonly id="latitude">
                                </div>
                            </div>
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
                    <div class="form-group">
                        <label for="nama_jalan">Nama Jalan</label>
                        <div class="form-autocomplete">
                            <input type="text" name="nama_jalan" class="form-control" placeholder="Cari jalan..."
                                autocomplete="off" id="nama_jalan">
                            <div class="result" id="results"></div>
                        </div>
                    </div>
                    <div id='map' style='height: 350px;'></div>
                </div>
            </div>
        </div>
    </div>
@endsection