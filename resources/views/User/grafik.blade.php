@extends('layouts.landing.app')
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Jumlah korban kecelakaan di
                            {{ request('nama_jalan') ? strtoupper(request('nama_jalan')) : 'semua lokasi' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET" id="filter-peta">
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nama_jalan">Nama Jalan</label>
                                        <input type="text" class="form-control" name="nama_jalan"
                                            placeholder="Jl. Adam Malik" autocomplete="off"
                                            value="{{ request('nama_jalan') ?? '' }}">
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
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Jumlah Kejadian per Kecamatan Tahun
                            {{ request('tahun_kejadian') ?? date('Y') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form action="" id="form-filter" method="GET">
                                    <div class="form-group">
                                        @php
                                            $startYear = 2021;
                                            $endYear = date('Y');
                                            $years = range($endYear, $startYear);
                                        @endphp
                                        <label for="tahun">Tahun</label>
                                        <select name="tahun_kejadian" id="tahun_kejadian" class="form-control">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year }}"
                                                    {{ request('tahun_kejadian') == $year ? 'selected' : '' }}>
                                                    {{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="chart">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="barChart2" width="1092" height="300" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $('#tahun_kejadian').on('change', function() {
            $('#form-filter').submit()
        });

        const totalLr = @json($total_lr);
        const totalLb = @json($total_lb);
        const totalMd = @json($total_md);
        const bulan = @json($data_bulan);
        const kecamatan = @json($kecamatan);
        const kejKecamatan = @json($kejadian_kecamatan);

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

        // BAR CHART 2
        new Chart($('#barChart2').get(0).getContext('2d'), {
            type: 'bar',
            data: $.extend(true, {}, {
                labels: kecamatan,
                datasets: [{
                    label: 'Kejadian',
                    backgroundColor: 'rgba(23,162,184,.8)',
                    borderColor: 'rgba(23,162,184,.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: kejKecamatan
                }]
            }),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                ticks: {
                    precision: 0
                }
            }
        });
    </script>
@endpush
