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
                                        <h4>{{ __('messages.report_list') }}</h4>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor')
                                            <a href="{{ route('laporan.create') }}"><button class="btn btn-primary">{{ __('messages.add_report') }}</button></a>
                                        @endif
                                    </div>
                                    <div style="overflow-x: scroll">
                                        <table id="zero-conf" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>{{ __('messages.report') }}</th>
                                                    <th>{{ __('messages.reporter') }}</th>
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
                                                                <span class="badge bg-danger text-danger">{{ __('messages.not_handled') }}</span>
                                                            @elseif($problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ __('messages.handling_process') }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ __('messages.completed_handled') }}</span>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button id="toa" class="btn btn-sm btn-primary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <i data-feather="menu"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a href="{{ route('laporan.show',$problem->id) }}" class="dropdown-item">Detail</a>
                                                                    @if (Auth::user()->role == 'pelapor')
                                                                        @if ($problem->status == 'belum ditangani')
                                                                            <a href="{{ route('laporan.edit',$problem->id) }}" class="dropdown-item">Edit</a>
                                                                            <a href="{{ route('editfotomasalah',$problem->id) }}" class="dropdown-item">Edit {{ __('messages.image') }}</a>
                                                                            <form action="{{route('laporan.destroy',$problem->id)}}" method="post" onsubmit="return confirm('{{ __('messages.are_u_sure') }}')">
                                                                                @csrf
                                                                                @method('delete')
                                                                                <button class="dropdown-item" style="margin-left: -20px; margin-top:-10px;"> {{ __('messages.delete') }}</button>
                                                                            </form>
                                                                        @endif
                                                                    @endif
                                                                    @if (Auth::user()->role == 'admin')
                                                                        <a href="{{ route('laporan.edit',$problem->id) }}" class="dropdown-item">Edit</a>
                                                                        <a href="{{ route('editfotomasalah',$problem->id) }}" class="dropdown-item">Edit Foto</a>
                                                                        <form action="{{route('laporan.destroy',$problem->id)}}" method="post" onsubmit="return confirm('Yakin hapus laporan?')">
                                                                            @csrf
                                                                            @method('delete')
                                                                            <button class="dropdown-item" style="margin-left: -20px; margin-top:-10px;"> Hapus</button>
                                                                        </form>
                                                                    @endif
                                                                    @if (Auth::user()->role == 'yayasan' || Auth::user()->role == 'admin')
                                                                        @if ($problem->status == 'belum ditangani')
                                                                            <a href="{{ route('tindakan-create',$problem->id) }}" style="margin-top:-10px;" class="dropdown-item">Ambil Penanganan Pertama</a>
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
