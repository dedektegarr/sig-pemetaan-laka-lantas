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
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-car-crash"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Kecelakaan</span>
                    <span class="info-box-number">{{ $data_kecelakaan->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-map-marker-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Data Lokasi</span>
                    <span class="info-box-number">{{ $data_lokasi->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Jumlah Korban Kecelakaan Lalu Lintas</h3>
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

        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Jumlah Kejadian per Kecamatan</h3>
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
                        <canvas id="barChart2" width="1092" height="300" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        // BAR CHART
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
            }),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
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
                datasetFill: false
            }
        });
    </script>
@endpush
