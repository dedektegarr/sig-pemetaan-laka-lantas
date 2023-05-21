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
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-print"></i>
                                    Cetak</a>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#addModal">
                                    <i class="fas fa-plus"></i>
                                    Tambah Data Kecelakaan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover text-center" id="table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:15px" class=" align-middle">No</th>
                                <th rowspan="2" class=" align-middle">Nama Jalan</th>
                                <th rowspan="2" class=" align-middle">Tahun</th>
                                <th colspan="4">Korban</th>
                                <th rowspan="2" class=" align-middle">Aksi</th>
                            </tr>
                            <tr>
                                <th class=" bg-info">Luka Ringan</th>
                                <th class=" bg-warning">Luka Berat</th>
                                <th class=" bg-danger">Meninggal</th>
                                <th class=" bg-primary">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data_kecelakaan as $kecelakaan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('lokasi.show', $kecelakaan->id_lokasi) }}">{{ $kecelakaan->lokasi->nama_jalan }}
                                        </a>
                                    </td>
                                    <td>{{ $kecelakaan->tanggal }}</td>
                                    <td>{{ $kecelakaan->luka_ringan }}</td>
                                    <td>{{ $kecelakaan->luka_berat }}</td>
                                    <td>{{ $kecelakaan->meninggal }}</td>
                                    <td>{{ $kecelakaan->total }}</td>
                                    <td>
                                        <a href="{{ route('kecelakaan.show', $kecelakaan->id_kecelakaan) }}"
                                            class="btn btn-info btn-sm" data-toggle="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal-{{ $kecelakaan->id_kecelakaan }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('kecelakaan.destroy', $kecelakaan->id_kecelakaan) }}"
                                            class="d-inline-block" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Anda yakin ingin menghapus data lokasi ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal-{{ $kecelakaan->id_kecelakaan }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('kecelakaan.update', $kecelakaan->id_kecelakaan) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Data Kecelakaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="id_lokasi">Nama Jalan</label>
                                                            <select
                                                                class="form-control @error('id_lokasi') is-invalid @enderror"
                                                                name="id_lokasi" id="id_lokasi">
                                                                <option value="">Pilih Jalan</option>
                                                                @foreach ($data_lokasi as $id_lokasi => $nama_lokasi)
                                                                    <option value="{{ $id_lokasi }}"
                                                                        {{ old('id_lokasi', $id_lokasi) == $id_lokasi ? 'selected' : '' }}>
                                                                        {{ $nama_lokasi }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('id_lokasi')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date"
                                                                class="form-control @error('tanggal') is-invalid @enderror"
                                                                name="tanggal"
                                                                value="{{ old('tanggal', $kecelakaan->tanggal) }}">
                                                            @error('tanggal')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="korban">Korban</label>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <input type="number"
                                                                        class="form-control @error('luka_ringan') is-invalid @enderror"
                                                                        name="luka_ringan" placeholder="LR"
                                                                        value="{{ old('luka_ringan', $kecelakaan->luka_ringan) }}">
                                                                    @error('luka_ringan')
                                                                        <span
                                                                            class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col">
                                                                    <input type="number"
                                                                        class="form-control @error('luka_berat') is-invalid @enderror"
                                                                        name="luka_berat" placeholder="LB"
                                                                        value="{{ old('luka_berat', $kecelakaan->luka_berat) }}">
                                                                    @error('luka_berat')
                                                                        <span
                                                                            class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col">
                                                                    <input type="number"
                                                                        class="form-control @error('meninggal') is-invalid @enderror"
                                                                        name="meninggal" placeholder="MD"
                                                                        value="{{ old('meninggal', $kecelakaan->meninggal) }}">
                                                                    @error('meninggal')
                                                                        <span
                                                                            class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('kecelakaan.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Kecelakaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="id_lokasi">Nama Jalan</label>
                            <select class="form-control @error('id_lokasi') is-invalid @enderror" name="id_lokasi"
                                id="id_lokasi">
                                <option value="">Pilih Jalan</option>
                                @foreach ($data_lokasi as $id_lokasi => $nama_lokasi)
                                    <option value="{{ $id_lokasi }}"
                                        {{ old('id_lokasi') == $id_lokasi ? 'selected' : '' }}>
                                        {{ $nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_lokasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                name="tanggal" value="{{ old('tanggal') }}">
                            @error('tanggal')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="korban">Korban</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control @error('luka_ringan') is-invalid @enderror"
                                        name="luka_ringan" placeholder="LR" value="{{ old('luka_ringan') }}">
                                    @error('luka_ringan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control @error('luka_berat') is-invalid @enderror"
                                        name="luka_berat" placeholder="LB" value="{{ old('luka_berat') }}">
                                    @error('luka_berat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control @error('meninggal') is-invalid @enderror"
                                        name="meninggal" placeholder="MD" value="{{ old('meninggal') }}">
                                    @error('meninggal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                ordering: false
            });

            $('.select2').select2();
        });

        // Alert ketika data berhasil ditambahkan
        @if (session()->has('success'))
            toastr.success('{{ session('success') }}')
        @endif

        @if ($errors->any())
            $('#addModal').modal('show');
        @enderror
    </script>
@endpush