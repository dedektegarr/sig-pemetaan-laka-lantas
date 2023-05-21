@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $lokasi->nama_jalan }}
                            </h3>
                        </div>
                        <div class="col">
                            <div class="float-right">
                                <a href="{{ route('lokasi.edit', $lokasi->id_lokasi) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('lokasi.destroy', $lokasi->id_lokasi) }}" class="d-inline-block"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Anda yakin ingin menghapus data lokasi ini?')">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div id="map" style="width:100%; height:300px"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-responsive mt-4">
                                <thead>
                                    <tr>
                                        <th>Nama Jalan</th>
                                        <th>Kota / Kabupaten</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan / Desa</th>
                                        <th>Longitude</th>
                                        <th>Latitude</th>
                                        <th>Keterangan</th>
                                        <th>Terakhir Update</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $lokasi->nama_jalan }}</td>
                                        <td>{{ $lokasi->kota_kabupaten }}</td>
                                        <td>{{ $lokasi->kecamatan->nama }}</td>
                                        <td>{{ $lokasi->kelurahan->nama }}</td>
                                        <td>{{ $lokasi->longitude }}</td>
                                        <td>{{ $lokasi->latitude }}</td>
                                        <td>{{ $lokasi->keterangan }}</td>
                                        <td>{{ $lokasi->updated_at->locale('id')->translatedFormat('d M Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Data Kecelakaan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" class="align-middle">Tahun</th>
                                <th colspan="4">Korban</th>
                            </tr>
                            <tr>
                                <th class="bg-info">LR</th>
                                <th class="bg-warning">LB</th>
                                <th class="bg-danger">MD</th>
                                <th class="bg-primary">Total</th>
                            </tr>

                        </thead>
                        <tbody>
                            @forelse ($data_kecelakaan as $kecelakaan)
                                <tr>
                                    <td>{{ $kecelakaan->tahun }}</td>
                                    <td>{{ $kecelakaan->luka_ringan }}</td>
                                    <td>{{ $kecelakaan->luka_berat }}</td>
                                    <td>{{ $kecelakaan->meninggal }}</td>
                                    <td>{{ $kecelakaan->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Tidak ada data kecelakaan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="" class="btn btn-default btn-block">Lihat lebih lengkap</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            setMap({
                lng: {{ $lokasi->longitude }},
                lat: {{ $lokasi->latitude }},
                zoom: 15,
                draggable: false
            });
        });
    </script>
@endpush
