@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $page_title }}</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="table">
                        <a href="{{ route('lokasi.tambah') }}" class="btn btn-info btn-sm mb-4">
                            <i class="fas fa-plus"></i>
                            Tambah data</a>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jalan</th>
                                <th>Kota / Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan / Desa</th>
                                <th>AKsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lokasi as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama_jalan }}</td>
                                    <td>{{ $data->kota_kabupaten }}</td>
                                    <td>{{ $data->kecamatan->nama }}</td>
                                    <td>{{ $data->kelurahan->nama }}</td>
                                    <td>
                                        <a href="" class="btn btn-info btn-sm" data-toggle="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="" class="d-inline-block">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
