@extends('layouts.app')

@section('content')

            <div class="page-content">
              <div class="main-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                            @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{session('success')}}
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{session('error')}}
                            </div>
                            @endif
                        </div>
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan')
                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Jumlah Masalah Belum Ditangani</h5>
                                        <h2>{{ $masalahbelum }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Jumlah Masalah Proses Penanganan</h5>
                                        <h2>{{ $masalahproses }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Jumlah Masalah Selesai Ditangani</h5>
                                        <h2>{{ $masalahselesai }}</h2>
                                    </div>
                                </div>
                            </div>
                        @endif

                </div>
                <div class="row">
                  <div class="col-sm-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Selamat datang di dashboard MATER, <span class="text-success">{{ Auth::user()->nama }}</span></h5>
                            <a href="{{ route('ubahpassword',Auth::user()->id) }}"><button class="btn btn-primary mt-2">Ubah Password</button></a>
                        </div>
                    </div>
                  </div>
                </div>
             </div>
            </div>

@endsection
