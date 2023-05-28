@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Lokasi Kejadian</h3>
                </div>
                <div class="card-body">
                    <div id='map' style='height: 350px;'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Kecelakaan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover bg-white text-center">
                        <thead>
                            <tr>
                                <th>No. Laka</th>
                                <th>Tgl. Laporan</th>
                                <th>Tgl. Kejadian</th>
                                <th>Tempat Kejadian</th>
                                <th>Luka Ringan</th>
                                <th>Luka Berat</th>
                                <th>Meninggal</th>
                                <th>Penyidik</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tgl_kejadian = \Carbon\Carbon::parse($kecelakaan->tgl_kejadian)->locale('id');
                                $tgl_laporan = \Carbon\Carbon::parse($kecelakaan->tgl_lp)->locale('id');
                            @endphp
                            <tr>
                                <td>{{ strtoupper($kecelakaan->no_laka) }}</td>
                                <td>{{ $tgl_laporan->translatedFormat('d M Y') }}</td>
                                <td>{{ $tgl_kejadian->translatedFormat('l, d M Y') }}</td>
                                <td>{{ $kecelakaan->lokasi->nama_jalan }}</td>
                                <td>{{ $kecelakaan->luka_ringan }}</td>
                                <td>{{ $kecelakaan->luka_berat }}</td>
                                <td>{{ $kecelakaan->meninggal }}</td>
                                <td>{{ $kecelakaan->keterangan }}</td>
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
        const kecelakaan = @json($kecelakaan);
        console.log(kecelakaan)
        $(document).ready(function() {
            setMap({
                lng: kecelakaan.lokasi.longitude,
                lat: kecelakaan.lokasi.latitude,
                zoom: 18,
                draggable: false
            });
        });
    </script>
@endpush
