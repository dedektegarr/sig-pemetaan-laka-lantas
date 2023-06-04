@extends('layouts.landing.app')
@section('css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .hero {
            background-color: #fff;
            padding: 60px 0;
        }

        .hero h1 {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 40px;
        }

        .hero .btn-primary {
            font-size: 16px;
            padding: 12px 24px;
        }

        .features {
            padding: 60px 0;
        }

        .features h3 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .features p {
            font-size: 16px;
            margin-bottom: 40px;
        }

        .feature-box {
            text-align: center;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .feature-box:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <h1>Selamat Datang di Sistem Informasi Geografis</h1>
                        <p>Temukan lokasi dan informasi kecelakaan lalu lintas di Kota Bengkulu</p>
                        <a href="{{ route('user.peta.index') }}" class="btn btn-primary">Mulai</a>
                    </div>
                    <div class="col-lg-7">
                        <img src="{{ asset('img/hero-img.jpg') }}" alt="Hero Image" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="feature-box">
                            <i class="fas fa-map-marked-alt fa-3x mb-4"></i>
                            <h3>Pemetaan Kecelakaan</h3>
                            <p>Visualisasikan lokasi kecelakaan lalu lintas dengan peta interaktif.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-box">
                            <i class="fas fa-chart-line fa-3x mb-4"></i>
                            <h3>Statistik Kecelakaan</h3>
                            <p>Peroleh data statistik kecelakaan lalu lintas untuk mendukung pengambilan keputusan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
