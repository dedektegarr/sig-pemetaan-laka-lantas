@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-6">
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
                            <select class="form-control" name="kota_kabupaten" id="kota_kabupaten">
                                <option value="">Pilih Kota / Kabupaten</option>
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelurahan_desa">Kelurahan / Desa</label>
                            <select class="form-control" name="kelurahan_desa" id="kelurahan_desa">
                                <option value="">Pilih Kelurahan / Desa</option>
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_jalan">Nama Jalan</label>
                            <select class="form-control" name="nama_jalan" id="nama_jalan">
                                <option value="">Pilih Jalan</option>
                                <option value="AL">Alabama</option>
                                <option value="WY">Wyoming</option>
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
    </div>
@endsection
