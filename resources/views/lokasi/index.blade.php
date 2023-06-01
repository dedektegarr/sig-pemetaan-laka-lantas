@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title">{{ $page_title }}</h3>
                        </div>
                        <div class="col">
                            <div class="float-right">
                                <button type="button" data-toggle="modal" data-target="#printModal"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-print"></i>
                                    Export</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jalan</th>
                                <th>Kelurahan / Desa</th>
                                <th>Kecamatan</th>
                                <th>Kota / Kabupaten</th>
                                <th>Bujur</th>
                                <th>Lintang</th>
                                <th>AKsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_lokasi as $lokasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lokasi->nama_jalan }}</td>
                                    <td>{{ $lokasi->kelurahan->nama ?? '-' }}</td>
                                    <td>{{ $lokasi->kecamatan->nama ?? '-' }}</td>
                                    <td>{{ $lokasi->kota_kabupaten }}</td>
                                    <td>{{ $lokasi->longitude }}</td>
                                    <td>{{ $lokasi->latitude }}</td>
                                    <td>
                                        <a href="{{ route('lokasi.show', $lokasi->nama_jalan) }}"
                                            class="btn btn-info btn-sm" data-toggle="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                            Lihat Peta
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('lokasi.export') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Export Data Lokasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_lokasi">Export Berdasarkan</label>
                            <select class="form-control @error('id_kecamatan') is-invalid @enderror" name="id_kecamatan"
                                id="id_kecamatan">
                                <option value="">Kecamatan</option>
                                @foreach ($data_kecamatan as $kecamatan)
                                    <option value="{{ $kecamatan->id }}"
                                        {{ request('id_kecamatan') == $kecamatan->id ? 'selected' : '' }}>
                                        {{ $kecamatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kecamatan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select class="form-control @error('id_lokasi') is-invalid @enderror" name="id_kelurahan"
                                id="id_lokasi">
                                <option value="">Kelurahan</option>
                                @foreach ($data_kelurahan as $kelurahan)
                                    <option value="{{ $kelurahan->id }}"
                                        {{ request('id_kelurahan') == $kelurahan->id ? 'selected' : '' }}>
                                        {{ $kelurahan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kelurahan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });

        select2Init('#id_lokasi', '#printModal');
        select2Init('#id_kecamatan', '#printModal');
        // Alert ketika data berhasil ditambahkan
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}')
        @endif
    </script>
@endpush
