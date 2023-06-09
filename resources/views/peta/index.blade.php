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
                                    <label for="nama_jalan">Nama Jalan</label>
                                    <input type="text" class="form-control" name="nama_jalan"
                                        placeholder="Jl. Adam Malik" autocomplete="off"
                                        value="{{ request('nama_jalan') ?? '' }}">
                                </div>
                            </div>
                            {{-- <div class="col">
                                <div class="form-group">
                                    <label for="id_kecamatan">Kecamatan</label>
                                    <select name="kecamatan" id="id_kecamatan" class="form-control select2">
                                        <option value="">Semua Kecamatan</option>
                                        @foreach ($data_kecamatan as $kecamatan)
                                            <option value="{{ $kecamatan->nama }}"
                                                {{ request('kecamatan') == $kecamatan->nama ? 'selected' : '' }}>
                                                {{ $kecamatan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
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
                                    <div style="transform: translateY(1.9em)">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <button type="button" id="resetBtn" class="btn btn-secondary">
                                            <i class="fas fa-sync"></i>
                                            Reset
                                        </button>
                                    </div>
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
        {{-- <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Jumlah Kejadian di
                        {{ request('nama_jalan') ? strtoupper(request('nama_jalan')) : 'semua lokasi' }}</h3>
                </div>
                <div class="card-body">
                    <p>Data Tahun : <strong>{{ request('tahun_kejadian') ?? 'Semua tahun' }}</strong></p>
                    <table class="table text-center table-bordered table-hover">
                        <thead class="bg-info">
                            <tr>
                                <th width="15px">No</th>
                                <th>Kecamatan</th>
                                <th width="200px">Kejadian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($total_kejadian as $lokasi => $total)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('lokasi.show', $lokasi) }}">
                                            {{ $lokasi }}
                                        </a>
                                    </td>
                                    <td>{{ $total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Jumlah korban kecelakaan di
                        {{ request('nama_jalan') ? strtoupper(request('nama_jalan')) : 'semua lokasi' }}</h3>
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
        // RESET FILTER
        $('#resetBtn').on('click', function() {
            window.history.replaceState({}, document.title, window.location.pathname);
            window.location.reload();
        });

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

        const totalLr = @json($total_lr);
        const totalLb = @json($total_lb);
        const totalMd = @json($total_md);
        const bulan = @json($data_bulan);

        // BAR CHART
        new Chart($('#barChart').get(0).getContext('2d'), {
            type: 'bar',
            data: $.extend(true, {}, {
                labels: bulan,
                datasets: [{
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

                ]
            }),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                ticks: {
                    precision: 0
                },
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    </script>
@endpush
