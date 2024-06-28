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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Daftar Tindakan Untuk {{ ucwords($problem->masalah) }}</h4> <br>
                                    @foreach ($tindakans as $tindakan)
                                        <p>Dilakukan Tindakan Pada : {{ date("d M Y H:i:s",strtotime($tindakan->created_at)) }}</p>
                                        <p>Tindakan : {{ ucfirst($tindakan->tindakan) }}</p>
                                        <p>Foto Bukti Tindakan : </p>
                                        @foreach ($tindakan_images[$tindakan->id] as $image)
                                            <a class="example-image-link"
                                            href="{{ asset('images/tindakan/'.$image->folder.'/'.$image->name) }}" data-lightbox="example-1">
                                            <img style="width: 120px; height:100px; object-fit:cover;" src="{{ asset('images/tindakan/'.$image->folder.'/'.$image->name) }}" alt=""></a>
                                        @endforeach
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan')
                                            <br><br>
                                            <a href="{{ route('tindakan-edit',$tindakan->id) }}"><button class="btn btn-primary">Edit</button></a>
                                            <a href="{{ route('editfototindakan',$tindakan->id) }}"><button class="btn btn-secondary">Edit Foto</button></a>
                                            <form action="{{ route('tindakan-destroy',$tindakan->id) }}" method="post" onsubmit="return confirm('Yakin hapus tindakan?')" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"> Hapus</button>
                                            </form>
                                        @endif
                                        <br><br>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

@endsection
