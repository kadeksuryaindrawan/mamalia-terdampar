@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Edit User</h5>
                                    <form method="POST" action="{{route('user.update',$user->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="nama" id="nama" value="{{ $user->nama }}" placeholder="Masukkan Nama" required>
                                                    @error('nama')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" name="email" value="{{ $user->email }}" id="email" placeholder="Masukkan Email" required>
                                                    @error('email')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="no_telp" class="form-label">No Telp</label>
                                                <input type="number" class="form-control" value="{{ $user->no_telp }}" name="no_telp" id="no_telp" placeholder="Masukkan No Telp" required>
                                                    @error('no_telp')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password">
                                                    @error('password')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label for="repassword" class="form-label">Re-Password</label>
                                                <input type="password" class="form-control" name="password_confirmation" id="repassword" placeholder="Masukkan Re-password">
                                                    @error('password')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <select name="role" id="role" class="form-select" required>
                                                    <option value="" selected disabled>- Pilih Role -</option>
                                                    @php
                                                        $role = ['admin', 'pelapor', 'yayasan', 'westerlaken'];
                                                    @endphp
                                                    @foreach ($role as $role)
                                                        <option value="{{ $role }}" {{ ($user->role == $role) ? 'selected' : ''; }}>{{ ucfirst($role) }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

@endsection
