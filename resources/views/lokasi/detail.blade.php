@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-6">
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
                                    <th>Longitude</th>
                                    <td>:</td>
                                    <td>{{ $lokasi->longitude }}</td>
                                </tr>
                                <tr>
                                    <th>Latitude</th>
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
