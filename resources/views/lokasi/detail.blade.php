@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa-sharp fa-regular fa-location-dot"></i>
                        {{ $lokasi->nama_jalan }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endsection
