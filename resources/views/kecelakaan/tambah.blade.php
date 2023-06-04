@extends('layouts.app')
@section('content')
    <form action="{{ route('kecelakaan.store') }}" method="POST" id="form">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="card-title">Lokasi Kejadian</h3>
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
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Lokasi Kejadian</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
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
                                    <label for="longitude">Bujur</label>
                                    <input type="text" class="form-control form-control-sm" name="longitude"
                                        autocomplete="off" value="{{ old('longitude') }}" readonly id="longitude">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Lintang</label>
                                    <input type="text" class="form-control form-control-sm" autocomplete="off"
                                        name="latitude" value="{{ old('latitude') }}" readonly id="latitude">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Kecelakaan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="no_laka">No. Laka</label>
                            <input type="text" class="form-control @error('no_laka') is-invalid @enderror" name="no_laka"
                                value="{{ old('no_laka') }}" placeholder="LP/A/1/I/{{ date('Y') }}"
                                style="text-transform: uppercase">
                            @error('no_laka')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_kejadian">Tanggal Kejadian</label>
                            <input type="datetime-local" class="form-control @error('tgl_kejadian') is-invalid @enderror"
                                name="tgl_kejadian" value="{{ old('tgl_kejadian') }}">
                            @error('tgl_kejadian')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tingkat_kecelakaan">Tingkat Kecelakaan</label>
                            <select name="tingkat_kecelakaan"
                                class="form-control @error('tingkat_kecelakaan') is-invalid @enderror"
                                id="tingkat_kecelakaan">
                                <option value="">Tingkat Kecelakaan</option>
                                <option value="ringan" {{ old('tingkat_kecelakaan') == 'ringan' ? 'selected' : '' }}>
                                    Ringan
                                </option>
                                <option value="sedang" {{ old('tingkat_kecelakaan') == 'sedang' ? 'selected' : '' }}>
                                    Sedang
                                </option>
                                <option value="berat" {{ old('tingkat_kecelakaan') == 'berat' ? 'selected' : '' }}>Berat
                                </option>
                            </select>
                            @error('tingkat_kecelakaan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="korban">Korban</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control @error('luka_ringan') is-invalid @enderror"
                                        name="luka_ringan" placeholder="LR" value="{{ old('luka_ringan') }}">
                                    @error('luka_ringan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control @error('luka_berat') is-invalid @enderror"
                                        name="luka_berat" placeholder="LB" value="{{ old('luka_berat') }}">
                                    @error('luka_berat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control @error('meninggal') is-invalid @enderror"
                                        name="meninggal" placeholder="MD" value="{{ old('meninggal') }}">
                                    @error('meninggal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary float-right mb-5">
                    <i class="fas fa-save mr-1"></i>
                    Simpan</button>
            </div>
        </div>
    </form>
@endsection
@push('script')
    <script>
        // API Wilayan Bengkulu
        const wilayahAPI = "http://localhost:8000/api";

        // tampilkan validasi alert
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', '', {
                    timeOut: 10000
                });
            @endforeach
        @endif

        $(document).ready(function() {
            // Inisiasi
            select2Init('.select2');

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

            if ($('#longitude').val() && $('#latitude').val()) {
                setMap({
                    lng: $('#longitude').val(),
                    lat: $('#latitude').val(),
                    zoom: 13
                });
            }
        });

        // Geocoding
        $('#nama_jalan').on('input', function(e) {
            // if (e.key === 'Enter' || e.keyCode === 13) {
            $('#results').css('display', 'none');
            if (this.value) {
                $('#results').css('display', 'block');
                const key = 'I3F9tUsDPOQ0Q2Po8xE2cId8p6mpkbyWOZB2AjzMm-g';
                $.get(`https://geocode.search.hereapi.com/v1/geocode?q=${this.value}&apiKey=${key}`,
                    function(
                        response) {
                        resultElement(response.items);
                    });
                // }
            }
        });

        // Ketka Result dari pencarian jalan di klik
        $('#results').on('click', function(e) {
            $('#nama_jalan').val(e.target.innerText);

            const kecamatan = @json($data_kecamatan);
            const kelurahan = @json($data_kelurahan);
            const resultText = e.target.innerText;

            fillKecKel(kecamatan, kelurahan, resultText);

            $.get(`${wilayahAPI}/kelurahan?id_kecamatan=${$('#kecamatan').val()}`, function(response) {
                newOptionElement($('#kelurahan_desa'), response.kelurahan);
            });

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
        $(window).on('click', () => $('#results').css('display', 'none'));

        // Ketika Kecamatan dipilih
        $('#kecamatan').on('select2:select', function(e) {
            const id = e.params.data.id;
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
