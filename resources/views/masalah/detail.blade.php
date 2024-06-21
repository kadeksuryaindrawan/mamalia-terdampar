@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Detail Masalah</h4>
                                    <p>Pelapor : {{ ucwords($problem->user->nama) }}</p>
                                    <p>Masalah : {{ ucwords($problem->masalah) }}</p>
                                    <p>Uraian : {{ ucfirst($problem->uraian) }}</p>
                                    <p>Alamat Kejadian : {{ ucfirst($problem->alamat_kejadian) }}</p>
                                    <p>Status : @if ($problem->status == 'belum ditangani')
                                                                <span class="badge bg-danger text-danger">{{ ucwords($problem->status) }}</span>
                                                            @elseif($problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ ucwords($problem->status) }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ ucwords($problem->status) }}</span>
                                                            @endif</p>
                                    <p>Dilaporkan Pada : {{ date("d M Y H:i:s",strtotime($problem->created_at)) }}</p>
                                    <p>Diedit Pada : {{ date("d M Y H:i:s",strtotime($problem->updated_at)) }}</p>
                                    <p>Foto : </p>
                                    @foreach ($images as $image)
                                        <a class="example-image-link"
                                        href="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" data-lightbox="example-1">
                                        <img style="width: 120px; height:100px; object-fit:cover;" src="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" alt=""></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

@endsection
