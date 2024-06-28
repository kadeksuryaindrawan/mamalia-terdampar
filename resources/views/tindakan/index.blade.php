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
                                        <h4>Daftar Tindakan</h4>
                                    </div>
                                    <div style="overflow-x: scroll">
                                        <table id="zero-conf" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Masalah</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @foreach ($tindakans as $tindakan)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ ucwords($tindakan->problem->masalah) }}</td>
                                                        <td>
                                                            @if ($tindakan->problem->status == 'belum ditangani')
                                                                <span class="badge bg-danger text-danger">{{ ucwords($tindakan->problem->status) }}</span>
                                                            @elseif($tindakan->problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ ucwords($tindakan->problem->status) }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ ucwords($tindakan->problem->status) }}</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button id="toa" class="btn btn-sm btn-primary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <i data-feather="menu"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                        <a href="{{ route('tindakan-detail',$tindakan->problem_id) }}" class="dropdown-item">Lihat Daftar Tindakan</a>
                                                                        <a href="{{ route('tindakan-terakhir',$tindakan->problem_id) }}" class="dropdown-item">Lihat Tindakan Terakhir</a>
                                                                        @if (Auth::user()->role == 'yayasan' || Auth::user()->role == 'admin')
                                                                            @if ($tindakan->problem->status == 'proses penanganan')
                                                                                <a href="{{ route('tindakan-create',$tindakan->problem_id) }}" class="dropdown-item">Update Tindakan Selanjutnya</a>
                                                                                <form action="{{route('tindakan-selesai',$tindakan->problem_id)}}" method="post" onsubmit="return confirm('Pastikan terlebih dahulu tindakan anda sudah sepenuhnya selesai dilakukan! Jika anda menyelesaikan tindakan, maka anda tidak dapat melakukan update tindakan selanjutnya! Apakah anda yakin ingin menyelesaikan tindakan? ')">
                                                                                    @csrf
                                                                                    @method('put')
                                                                                    <button class="dropdown-item" style="margin-left: -20px; margin-top:-10px;"> Selesaikan Tindakan</button>
                                                                                </form>
                                                                            @endif
                                                                        @endif
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
