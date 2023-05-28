@extends('layouts.app')
@section('content')
    @php
        $data_kecelakaan = collect($data_kecelakaan);
    @endphp
    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $lokasi->nama_jalan }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div id="map" style="width:100%; height:400px"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <table class="" cellpadding="5">
                                <tr>
                                    <th>Nama Jalan</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->nama_jalan }}</td>
                                </tr>
                                <tr>
                                    <th>Kota / Kabupaten</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->kota_kabupaten }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->kecamatan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Kelurahan</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->kelurahan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Bujur</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->longitude }}</td>
                                </tr>
                                <tr>
                                    <th>Lintang</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->latitude }}</td>
                                </tr>
                                <tr>
                                    <th>Terkahir di Update</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->updated_at->locale('id')->translatedFormat('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="h3 card-title">Kecelakaan Tercatat</div>
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
                    <form action="" method="GET" id="form-filter">
                        @php
                            $startYear = 2021;
                            $endYear = date('Y');
                            $years = range($endYear, $startYear);
                        @endphp
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <table cellpadding="6">
                        <td>Total kecelakaan tercatat di tahun {{ request('tahun') ?? date('Y') }}</td>
                        <td>:</td>
                        <th>{{ $data_kecelakaan->count() }} kasus</th>
                    </table>

                    <table class="table text-center table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="bg-secondary">Bulan</th>
                                <th class="bg-info">Luka Ringan</th>
                                <th class="bg-warning">Luka Berat</th>
                                <th class="bg-danger">Meninggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_bulan as $index => $bulan)
                                <tr>
                                    <td>{{ $bulan }}</td>
                                    @php
                                        $dataBulan = $data_kecelakaan->filter(function ($kecelakaan) use ($index) {
                                            return (int) date('m', strtotime($kecelakaan->tgl_kejadian)) == $index + 1;
                                        });
                                    @endphp
                                    <td>{{ $dataBulan->sum('luka_ringan') }}</td>
                                    <td>{{ $dataBulan->sum('luka_berat') }}</td>
                                    <td>{{ $dataBulan->sum('meninggal') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>Total</th>
                                <th>{{ $data_kecelakaan->sum('luka_ringan') }}</th>
                                <th>{{ $data_kecelakaan->sum('luka_berat') }}</th>
                                <th>{{ $data_kecelakaan->sum('meninggal') }}</th>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const popUpContent = (data) => {
            return `<strong class="mb-3 d-block">${data.lokasi.nama_jalan}</strong>
                    <table cellpadding="7" border="1" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th>Tanggal</th>
                                <th>Korban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">${data.tgl_kejadian}</td>
                                <td>
                                    <table cellpadding="3">
                                        <tr>
                                            <td>Luka Ringan</td>
                                            <td>:</td>
                                            <td>${data.luka_ringan}</td>
                                        </tr>
                                        <tr>
                                            <td>Luka Berat</td>
                                            <td>:</td>
                                            <td>${data.luka_berat}</td>
                                        </tr>
                                        <tr>
                                            <td>Meninggal</td>
                                            <td>:</td>
                                            <td>${data.meninggal}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>`;
        }

        const dataKecelakaan = @json($data_kecelakaan);
        let longLat = [102.263641, -3.792228];

        if (dataKecelakaan.length) {
            const dataLokasi = dataKecelakaan.map(function(data) {
                return data.lokasi;
            });
            longLat = [dataLokasi[0].longitude, dataLokasi[0].latitude];
        }

        $(document).ready(function() {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: longLat,
                zoom: 14,
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.FullscreenControl());

            if (dataKecelakaan.length) {
                for (let kecelakaan of dataKecelakaan) {
                    var marker = new mapboxgl.Marker()
                        .setLngLat({
                            lng: kecelakaan.lokasi.longitude,
                            lat: kecelakaan.lokasi.latitude
                        })
                        .addTo(map);

                    const popup = new mapboxgl.Popup({
                            closeOnClick: true
                        })
                        .setHTML(popUpContent(kecelakaan));

                    marker.setPopup(popup);
                }
            }
        });

        $('#tahun').on('change', function() {
            $('#form-filter').submit()
        });
    </script>
@endpush
