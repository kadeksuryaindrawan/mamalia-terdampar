@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    @if (Auth::user()->role == 'pelapor')
                                        <h5 class="card-title">Form {{ __('messages.change_password') }}</h5>
                                    @else
                                        <h5 class="card-title">Form Ubah Password</h5>
                                    @endif

                                    <form method="POST" action="{{route('updatepassword',$user->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    @if (Auth::user()->role == 'pelapor')
                                                        <label for="password" class="form-label">Password ({{ __('messages.minimum_8') }})</label>
                                                    @else
                                                        <label for="password" class="form-label">Password (minimal 8 karakter)</label>
                                                    @endif

                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                                    @error('password')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label for="repassword" class="form-label">Password Confirmation</label>
                                                <input type="password" class="form-control" name="password_confirmation" id="repassword" placeholder="Password Confirmation" required>
                                                    @error('password')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @if (Auth::user()->role == 'pelapor')
                                            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        @endif

                                      </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

@endsection
