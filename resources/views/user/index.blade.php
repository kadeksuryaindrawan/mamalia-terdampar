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
                                        <h4>User</h4>
                                        <a href="{{ route('user.create') }}"><button class="btn btn-primary">Tambah User</button></a>
                                    </div>
                                    <div style="overflow-x: scroll">
                                        <table id="zero-conf" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Email</th>
                                                    <th>Nama</th>
                                                    <th>No Telp</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no=1;
                                                @endphp
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ ucwords($user->nama) }}</td>
                                                        <td>{{ $user->no_telp }}</td>
                                                        <td>{{ $user->role }}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button id="toa" class="btn btn-sm btn-primary" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                                    <i data-feather="menu"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    {{-- <a href="{{ route('jenis.show',$item->id) }}" class="dropdown-item"><i class="bi bi-search"></i> Detail Jenis</a> --}}
                                                                    <a href="{{ route('user.edit',$user->id) }}" class="dropdown-item"><i data-feather="edit"></i> Edit</a>

                                                                    <form action="{{route('user.destroy',$user->id)}}" method="post" onsubmit="return confirm('Yakin hapus user?')">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="dropdown-item" style="margin-left: -22px;"><i data-feather="trash"></i> Hapus</button>
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
