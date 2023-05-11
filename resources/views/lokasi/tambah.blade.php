@extends('layouts.app')
@section('body-class', 'map-page')
@section('content')
    <form action="{{ route('lokasi.insert') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Data Lokasi</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kota_kabupaten">Kota / Kabupaten</label>
                            <input type="text" class="form-control" name="kota_kabupaten" value="Kota Bengkulu" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select class="form-control select2" name="id_kecamatan" id="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelurahan_desa">Kelurahan / Desa</label>
                            <select class="form-control select2" name="id_kelurahan" id="kelurahan_desa">
                                <option value="">Pilih Kecamatan Terlebih Dahulu</option>
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
    </form>
@endsection
