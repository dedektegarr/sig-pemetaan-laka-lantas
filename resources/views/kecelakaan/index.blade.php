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
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#printModal">
                                    <i class="fas fa-print"></i>
                                    Export
                                </button>
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
                    <form action="{{ route('kecelakaan.index') }}" method="GET" class="bg-secondary mb-3 p-3 rounded">
                        <div class="form-group">
                            <label for="id_kecamatan">Filter</label>
                            <select class="form-control @error('id_kecamatan') is-invalid @enderror" name="id_kecamatan"
                                id="id_kecamatan">
                                <option value="">Semua Kecamatan</option>
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
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control @error('bulan') is-invalid @enderror" name="bulan"
                                        id="bulan">
                                        <option value="">Dari Bulan</option>
                                        @foreach ($data_bulan as $index => $bulan)
                                            <option value="{{ $index + 1 }}"
                                                {{ request('bulan') == $index + 1 ? 'selected' : '' }}>
                                                {{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control @error('bulan_akhir') is-invalid @enderror"
                                        name="bulan_akhir" id="bulan_akhir">
                                        <option value="">Sampai Bulan</option>
                                        @foreach ($data_bulan as $index => $bulan)
                                            <option value="{{ $index + 1 }}"
                                                {{ request('bulan_akhir') == $index + 1 ? 'selected' : '' }}>
                                                {{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan_akhir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <select required name="tahun"
                                        class="form-control @error('bulan_akhir') is-invalid @enderror">
                                        @php
                                            $startYear = 2021;
                                            $endYear = date('Y');
                                            $years = range($endYear, $startYear);
                                        @endphp

                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                    Cari
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-hover text-center" id="table">
                        <thead>
                            <tr>
                                <th rowspan="2" style="width:15px" class=" align-middle">No</th>
                                <th rowspan="2" class=" align-middle">No. Laka</th>
                                <th rowspan="2" class=" align-middle">Nama Jalan</th>
                                <th rowspan="2" class=" align-middle">Kecamatan</th>
                                <th rowspan="2" class=" align-middle">Tgl. Kejadian</th>
                                <th colspan="4">Korban</th>
                                <th rowspan="2" class=" align-middle" width="120px">Aksi</th>
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
                                    <td style="max-width: 150px; text-transform: uppercase">
                                        {{ $kecelakaan->no_laka }}
                                    </td>
                                    <td>
                                        <a href="{{ route('lokasi.show', $kecelakaan->id_lokasi) }}">{{ $kecelakaan->lokasi->nama_jalan }}
                                        </a>
                                    </td>
                                    <td>{{ $kecelakaan->lokasi->kecamatan->nama }}</td>
                                    <td>{{ $kecelakaan->tgl_kejadian }}</td>
                                    <td>{{ $kecelakaan->luka_ringan }}</td>
                                    <td>{{ $kecelakaan->luka_berat }}</td>
                                    <td>{{ $kecelakaan->meninggal }}</td>
                                    <td>{{ $kecelakaan->total }}</td>
                                    <td id="actionBtn">
                                        <a href="{{ route('kecelakaan.show', $kecelakaan->id_kecelakaan) }}"
                                            class="btn btn-info btn-sm" data-toggle="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal-{{ $kecelakaan->id_kecelakaan }}" id="editBtn">
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
                                    <div class="modal fade" id="editModal-{{ $kecelakaan->id_kecelakaan }}"
                                        tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form
                                                    action="{{ route('kecelakaan.update', $kecelakaan->id_kecelakaan) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit
                                                            Data
                                                            Kecelakaan
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="no_laka">No. Laka</label>
                                                            <input type="text"
                                                                class="form-control @error('no_laka') is-invalid @enderror"
                                                                name="no_laka"
                                                                value="{{ old('no_laka', $kecelakaan->no_laka) }}"
                                                                placeholder="LP/A/1/I/{{ date('Y') }}"
                                                                style="text-transform: uppercase">
                                                            @error('no_laka')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="id_lokasi">Nama Jalan</label>
                                                            <select
                                                                class="form-control @error('id_lokasi') is-invalid @enderror"
                                                                name="id_lokasi" id="id_lokasi">
                                                                <option value="">Pilih Jalan</option>
                                                                @foreach ($data_lokasi as $lokasi)
                                                                    <option value="{{ $lokasi->id_lokasi }}"
                                                                        {{ old('id_lokasi', $kecelakaan->id_lokasi) == $lokasi->id_lokasi ? 'selected' : '' }}>
                                                                        {{ $lokasi->nama_jalan }}
                                                                        {{ $lokasi->kecamatan->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('id_lokasi')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tgl_lp">Tanggal Laporan</label>
                                                            <input type="date"
                                                                class="form-control @error('tgl_lp') is-invalid @enderror"
                                                                name="tgl_lp"
                                                                value="{{ old('tgl_lp', $kecelakaan->tgl_lp) }}">
                                                            @error('tgl_lp')
                                                                <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tgl_kejadian">Tanggal kejadian</label>
                                                            <input type="datetime-local"
                                                                class="form-control @error('tgl_kejadian') is-invalid @enderror"
                                                                name="tgl_kejadian"
                                                                value="{{ old('tgl_kejadian', $kecelakaan->tgl_kejadian) }}">
                                                            @error('tgl_kejadian')
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
                </form>
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
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Kecelakaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_laka">No. Laka</label>
                            <input type="text" class="form-control @error('no_laka') is-invalid @enderror"
                                name="no_laka" value="{{ old('no_laka') }}" placeholder="LP/A/1/I/{{ date('Y') }}"
                                style="text-transform: uppercase">
                            @error('no_laka')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_lokasi">Nama Jalan</label>
                            <select class="form-control select2-add @error('id_lokasi') is-invalid @enderror"
                                name="id_lokasi" id="id_lokasi">
                                <option value="">Pilih Jalan</option>
                                @foreach ($data_lokasi as $lokasi)
                                    <option value="{{ $lokasi->id_lokasi }}"
                                        {{ old('id_lokasi') == $lokasi->id_lokasi ? 'selected' : '' }}>
                                        {{ $lokasi->nama_jalan }} {{ $lokasi->kecamatan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_lokasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_lp">Tanggal Laporan</label>
                            <input type="date" class="form-control @error('tgl_lp') is-invalid @enderror"
                                name="tgl_lp" value="{{ old('tgl_lp') }}" id="tgl_lp">
                            @error('tgl_lp')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_kejadian">Tanggal Kejadian</label>
                            <input type="datetime-local" class="form-control @error('tgl_kejadian') is-invalid @enderror"
                                name="tgl_kejadian" value="{{ old('tgl_kejadian') }}">
                            @error('tgl_kejadian')
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

    <!-- Print Modal -->
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('kecelakaan.export') }}" method="GET">
                    <div class="modal-header">
                        <h5 class="modal-title" id="printModalLabel">Cetak Data Kecelakaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_kecamatan">Cetak Berdasarkan</label>
                            <select class="form-control @error('id_kecamatan') is-invalid @enderror" name="id_kecamatan"
                                id="id_kecamatan_print">
                                <option value="all">Semua Kecamatan</option>
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
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control @error('bulan') is-invalid @enderror" name="bulan"
                                        id="bulan">
                                        <option value="">Sampai Bulan</option>
                                        @foreach ($data_bulan as $index => $bulan)
                                            <option value="{{ $index + 1 }}"
                                                {{ request('bulan') == $index + 1 ? 'selected' : '' }}>
                                                {{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control @error('bulan_akhir') is-invalid @enderror"
                                        name="bulan_akhir" id="bulan_akhir">
                                        <option value="">Sampai Bulan</option>
                                        @foreach ($data_bulan as $index => $bulan)
                                            <option value="{{ $index + 1 }}"
                                                {{ request('bulan_akhir') == $index + 1 ? 'selected' : '' }}>
                                                {{ $bulan }}</option>
                                        @endforeach
                                    </select>
                                    @error('bulan_akhir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <select name="tahun"
                                        class="form-control @error('bulan_akhir') is-invalid @enderror">
                                        @php
                                            $startYear = 2020;
                                            $endYear = date('Y');
                                            $years = range($endYear, $startYear);
                                        @endphp

                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
        // RESET FILTER
        $('#resetBtn').on('click', function() {
            window.history.replaceState({}, document.title, window.location.pathname);
            window.location.reload();
        });

        $(document).ready(function() {
            $('#table').DataTable({
                ordering: false
            });

            // SELECT2
            const actionBtn = $('#actionBtn');
            actionBtn.on('click', function(e) {
                const editModal = e.target.getAttribute('data-target');
                $(editModal).on('show.bs.modal', function() {
                    select2Init('#id_lokasi', editModal);
                })
            });

            select2Init('#id_kecamatan');
            select2Init('#id_kecamatan_print', '#printModal');
            select2Init('.select2-add', '#addModal');

            // set tanggal saat ini kedalam form tanggal LP
            $('#tgl_lp').val(new Date().toISOString().split("T")[0]);
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
