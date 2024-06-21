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
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h4>Daftar Masalah</h4>
                                        <a href="{{ route('masalah.create') }}"><button class="btn btn-primary">Tambah Masalah</button></a>
                                    </div>
                                    <div style="overflow-x: scroll">
                                        <table id="zero-conf" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Masalah</th>
                                                    <th>Pelapor</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @foreach ($problems as $problem)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ ucwords($problem->masalah) }}</td>
                                                        <td>{{ ucwords($problem->user->nama) }}</td>
                                                        <td>
                                                            @if ($problem->status == 'belum ditangani')
                                                                <span class="badge bg-danger text-danger">{{ ucwords($problem->status) }}</span>
                                                            @elseif($problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ ucwords($problem->status) }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ ucwords($problem->status) }}</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button id="toa" class="btn btn-sm btn-primary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <i data-feather="menu"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a href="{{ route('masalah.show',$problem->id) }}" class="dropdown-item">Detail</a>
                                                                    <a href="{{ route('masalah.edit',$problem->id) }}" class="dropdown-item">Edit</a>
                                                                    <a href="{{ route('editfotomasalah',$problem->id) }}" class="dropdown-item">Edit Foto</a>
                                                                    <form action="{{route('masalah.destroy',$problem->id)}}" method="post" onsubmit="return confirm('Yakin hapus masalah?')">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="dropdown-item" style="margin-left: -20px; margin-top:-10px;"> Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    </div>

@endsection
