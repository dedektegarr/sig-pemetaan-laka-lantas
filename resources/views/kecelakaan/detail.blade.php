@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title">Data Kecelakaan</h3>
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
                    <table class="table table-hover bg-white text-center">
                        <thead>
                            <tr>
                                <th width="5px">No. Laka</th>
                                <th>Tgl. Kejadian</th>
                                <th>Tempat Kejadian</th>
                                <th>Tingkat Kecelakaan</th>
                                <th class="bg-info">Luka Ringan</th>
                                <th class="bg-warning">Luka Berat</th>
                                <th class="bg-danger">Meninggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $tgl_kejadian = \Carbon\Carbon::parse($kecelakaan->tgl_kejadian)->locale('id');
                                $tgl_laporan = \Carbon\Carbon::parse($kecelakaan->tgl_lp)->locale('id');
                            @endphp
                            <tr>
                                <td>{{ strtoupper($kecelakaan->no_laka) }}</td>
                                <td>{{ $tgl_kejadian->translatedFormat('l, d M Y') }}</td>
                                <td>{{ $kecelakaan->lokasi->nama_jalan }}</td>
                                <td>{{ $kecelakaan->tingkat_kecelakaan }}</td>
                                <td>{{ $kecelakaan->luka_ringan }}</td>
                                <td>{{ $kecelakaan->luka_berat }}</td>
                                <td>{{ $kecelakaan->meninggal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Lokasi Kejadian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div id='map' style='height: 350px;'></div>
                        </div>
                        <div class="col">
                            <table cellpadding="8">
                                <tr>
                                    <td width="200px">Nama Jalan</td>
                                    <td>:</td>
                                    <td>{{ $kecelakaan->lokasi->nama_jalan }}</td>
                                </tr>
                                <tr>
                                    <td>Kelurahan</td>
                                    <td>:</td>
                                    <td>{{ $kecelakaan->lokasi->kelurahan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td>{{ $kecelakaan->lokasi->kecamatan->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Bujur</td>
                                    <td>:</td>
                                    <td>{{ $kecelakaan->lokasi->longitude }}</td>
                                </tr>
                                <tr>
                                    <td>Lintang</td>
                                    <td>:</td>
                                    <td>{{ $kecelakaan->lokasi->latitude }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('kecelakaan.edit', $kecelakaan->id_kecelakaan) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <form action="{{ route('kecelakaan.destroy', $kecelakaan->id_kecelakaan) }}" class="d-inline-block"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Anda yakin ingin menghapus data kecelakaan ini?')">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
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
