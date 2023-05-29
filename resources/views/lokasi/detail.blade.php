@extends('layouts.app')
@section('content')
    @php
        $data_kecelakaan = collect($data_kecelakaan);
        $total_lr = [];
        $total_lb = [];
        $total_md = [];
        foreach ($data_bulan as $index => $bulan) {
            $filtered = $data_kecelakaan->filter(function ($kecelakaan) use ($index) {
                return (int) date('m', strtotime($kecelakaan->tgl_kejadian)) == $index + 1;
            });
        
            $total_lr[] = $filtered->sum('luka_ringan');
            $total_lb[] = $filtered->sum('luka_berat');
            $total_md[] = $filtered->sum('meninggal');
        }
    @endphp
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Jumlah korban kecelakaan di {{ $lokasi->nama_jalan }} tahun
                        {{ request('tahun') ?? date('Y') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="barChart" width="1092" height="300" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Lokasi Kejadian</h3>
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
                    <div class="h3 card-title">Kecelakaan Tercatat</div>
                </div>
                <div class="card-body">
                    <table cellpadding="6">
                        <td>Total kecelakaan tercatat di tahun {{ request('tahun') ?? date('Y') }}</td>
                        <td>:</td>
                        <th>{{ $data_kecelakaan->count() }} kejadian</th>
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
                style: 'mapbox://styles/mapbox/dark-v11',
                center: longLat,
                zoom: 14,
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.FullscreenControl());

            if (dataKecelakaan.length) {
                for (let kecelakaan of dataKecelakaan) {
                    const myMarker = customMarker(kecelakaan);
                    var marker = new mapboxgl.Marker(myMarker)
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

        // BAR CHART
        const totalLr = @json($total_lr);
        const totalLb = @json($total_lb);
        const totalMd = @json($total_md);
        const bulan = @json($data_bulan);

        var areaChartData = {
            labels: bulan,
            datasets: [{
                    label: 'Luka Ringan',
                    backgroundColor: 'rgba(23,162,184,.8)',
                    borderColor: 'rgba(23,162,184,.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: totalLr
                },
                {
                    label: 'Luka Berat',
                    backgroundColor: 'rgba(255, 193, 7, .8)',
                    borderColor: 'rgba(255, 193, 7, .8)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: totalLb
                },
                {
                    label: 'Meninggal',
                    backgroundColor: 'rgba(220, 53, 69, .8)',
                    borderColor: 'rgba(220, 53, 69, .8)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: totalMd
                },
            ]
        }

        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        var temp2 = areaChartData.datasets[2]
        barChartData.datasets[0] = temp0
        barChartData.datasets[1] = temp1
        barChartData.datasets[2] = temp2

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })
    </script>
@endpush
