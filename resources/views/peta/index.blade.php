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
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Lihat Berdasarkan</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="GET" id="filter-peta">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="id_lokasi">Nama Jalan</label>
                                    <select name="nama_jalan" id="nama_jalan" class="form-control select2">
                                        <option value="">Semua Lokasi</option>
                                        @foreach ($data_lokasi as $lokasi)
                                            <option value="{{ $lokasi->nama_jalan }}"
                                                {{ request('nama_jalan') == $lokasi->nama_jalan ? 'selected' : '' }}>
                                                {{ $lokasi->nama_jalan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    @php
                                        $startYear = 2021;
                                        $endYear = date('Y');
                                        $years = range($endYear, $startYear);
                                    @endphp
                                    <label for="tahun">Tahun</label>
                                    <select name="tahun_kejadian" id="tahun" class="form-control">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun_kejadian') == $year ? 'selected' : '' }}>
                                                {{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" style="transform: translateY(1.9em)">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="map" style="height:500px"></div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Jumlah korban kecelakaan
                        {{ request('tahun_kejadian') ?? '' }} di {{ request('nama_jalan') ?? 'semua lokasi' }}</h3>
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
@endsection
@push('script')
    <script>
        const data = @json($data_kecelakaan);

        const popUpContent = (data) => {
            return `<strong class="mb-3 d-block">${data.lokasi.nama_jalan}</strong>
                    <table cellpadding="7" border="1" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th>Tahun</th>
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

        $(document).ready(function() {
            // Inisiasi
            select2Init('.select2');

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [102.263641, -3.792228],
                zoom: 11,
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.FullscreenControl());

            for (let item in data) {
                const location = data[item].lokasi;
                // Marker Color Rules
                // markerBackground = markerRules(data[item]);

                const myMarker = customMarker(data[item]);
                var marker = new mapboxgl.Marker(myMarker)
                    .setLngLat([location.longitude, location.latitude])
                    .addTo(map);

                const popup = new mapboxgl.Popup({
                        closeOnClick: true
                    })
                    .setHTML(popUpContent(data[item]));

                marker.setPopup(popup);
            }
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
