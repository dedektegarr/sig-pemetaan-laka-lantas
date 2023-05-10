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
                        <a href="{{ route('lokasi.tambah') }}" class="btn btn-info mb-4">
                            <i class="fas fa-plus"></i>
                            Tambah data</a>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Dedek Tegar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
