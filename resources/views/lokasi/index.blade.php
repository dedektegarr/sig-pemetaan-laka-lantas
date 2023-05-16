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
                            @foreach ($data_lokasi as $lokasi)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ $lokasi->nama_jalan }}</td>
                                    <td>{{ $lokasi->kota_kabupaten }}</td>
                                    <td>{{ $lokasi->kecamatan->nama }}</td>
                                    <td>{{ $lokasi->kelurahan->nama }}</td>
                                    <td>
                                        <a href="{{ route('lokasi.show', $lokasi->id_lokasi) }}" class="btn btn-info btn-sm"
                                            data-toggle="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('lokasi.edit', $lokasi->id_lokasi) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('lokasi.destroy', $lokasi->id_lokasi) }}"
                                            class="d-inline-block" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Anda yakin ingin menghapus data lokasi ini?')">
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
@push('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });

        // Alert ketika data berhasil ditambahkan
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}')
        @endif
    </script>
@endpush
