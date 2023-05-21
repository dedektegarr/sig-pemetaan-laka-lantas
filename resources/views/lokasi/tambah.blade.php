@extends('layouts.app')
@section('content')
    <form action="{{ route('lokasi.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col">
            </div>
        </div>
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
                            <input type="text" class="form-control @error('kota_kabupaten') is-invalid @enderror"
                                name="kota_kabupaten" value="Kota Bengkulu">
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select class="form-control select2" name="id_kecamatan" id="kecamatan">
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($data_kecamatan as $kecamatan)
                                    <option value="{{ $kecamatan->id }}"
                                        {{ old('id_kecamatan') == $kecamatan->id ? 'selected' : '' }}>{{ $kecamatan->nama }}
                                    </option>
                                @endforeach
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
                                        name="longitude" autocomplete="off" value="{{ old('longitude') }}" readonly
                                        id="longitude">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="latitude"
                                        autocomplete="off" name="latitude" value="{{ old('latitude') }}" readonly
                                        id="latitude">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
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
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="card-title">Koordinat</h3>
                            </div>
                            <div class="col">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_jalan">Nama Jalan</label>
                            <div class="form-autocomplete">
                                <input type="text" name="nama_jalan" class="form-control" placeholder="Cari jalan..."
                                    autocomplete="off" id="nama_jalan" value="{{ old('nama_jalan') }}">
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
@push('script')
    <script>
        // API Wilayan Bengkulu
        const wilayahAPI = "http://localhost:8000/api";

        $(document).ready(function() {
            // Menampilkan Map
            setMap({
                lng: 102.263641,
                lat: -3.792228,
                zoom: 13,
                draggable: true
            });

            // Ambil data kelurahan jika ada data kecamatan
            if ($('#kecamatan').val()) {
                $('#kelurahan_desa').html('');
                $.get(`${wilayahAPI}/kelurahan?id_kecamatan=${$('#kecamatan').val()}`, function(response) {
                    newOptionElement($('#kelurahan_desa'), response.kelurahan);
                });
            }

            $(window).on('click', () => $('#results').css('display', 'none'));
            $('.select2').select2();

            if ($('#longitude').val() && $('#latitude').val()) {
                setMap({
                    lng: $('#longitude').val(),
                    lat: $('#latitude').val(),
                    zoom: 13
                });
            }
        });

        // tampilkan validasi
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', '', {
                    timeOut: 10000
                });
            @endforeach
        @endif

        // Geocoding
        $('#nama_jalan').on('input', function() {
            $('#results').css('display', 'none');
            if (this.value) {
                $('#results').css('display', 'block');
                const key = 'I3F9tUsDPOQ0Q2Po8xE2cId8p6mpkbyWOZB2AjzMm-g';
                $.get(`https://geocode.search.hereapi.com/v1/geocode?q=${this.value}&apiKey=${key}`, function(
                    response) {
                    resultElement(response.items);
                });
            }
        });

        // Ketka Result dari pencarian jalan di klik
        $('#results').on('click', function(e) {
            $('#nama_jalan').val(e.target.innerText);
            $('#results').css('display', 'none');
            const getPosition = e.target.getAttribute('data-coor').split(',');
            const position = {
                lng: getPosition[0],
                lat: getPosition[1],
                zoom: 15,
                draggable: true
            };

            $('#longitude').val(position.lng);
            $('#latitude').val(position.lat);

            setMap(position);
        });

        // Ketika Kecamatan dipilih
        $('#kecamatan').on('select2:select', function(e) {
            const id = e.params.data.id;
            console.log(e.params.data);
            $('#kelurahan_desa').html('<option value="">Pilih Kecamatan Terlebih Dahulu</option>');
            if (id) {
                $('#kelurahan_desa').html('');
                $.get(`${wilayahAPI}/kelurahan?id_kecamatan=${id}`, function(response) {
                    newOptionElement($('#kelurahan_desa'), response.kelurahan);
                });
            }
        });
    </script>
@endpush
