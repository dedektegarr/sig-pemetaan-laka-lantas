@extends('layouts.app')
@section('content')
    <form action="{{ route('lokasi.update', $lokasi->id_lokasi) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Edit Data Lokasi</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kota_kabupaten">Kota / Kabupaten</label>
                            <input type="text" class="form-control @error('kota_kabupaten') is-invalid @enderror"
                                name="kota_kabupaten" value="Kota Bengkulu" readonly>
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
                                        name="longitude" autocomplete="off"
                                        value="{{ old('longitude', $lokasi->longitude) }}" readonly id="longitude">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="latitude"
                                        autocomplete="off" name="latitude" value="{{ old('latitude', $lokasi->latitude) }}"
                                        readonly id="latitude">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control">{{ old('keterangan', $lokasi->keterangan) }}</textarea>
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
                                    autocomplete="off" id="nama_jalan" value="{{ old('nama_jalan', $lokasi->nama_jalan) }}">
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
                lng: {{ $lokasi->longitude }},
                lat: {{ $lokasi->latitude }},
                zoom: 15,
                draggable: true
            });

            // ambil data kecamatan pada saat pertama kali form input terbuka
            $.get(`${wilayahAPI}/kecamatan`, function(response) {
                newOptionElement($('#kecamatan'), response.kecamatan);
            });

            $(window).on('click', () => $('#results').css('display', 'none'));
            $('.select2').select2();
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
