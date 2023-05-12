@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
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
                                        <td>{{ $lokasi->updated_at->format('d M Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
