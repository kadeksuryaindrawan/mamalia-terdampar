@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Edit Masalah</h5>
                                    <form method="POST" action="{{route('masalah.update',$problem->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="masalah" class="form-label">Masalah</label>
                                                <input type="text" class="form-control" value="{{ $problem->masalah }}" name="masalah" id="masalah" placeholder="Masukkan Masalah" required>
                                                    @error('masalah')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="uraian" class="form-label">Uraian Masalah</label>
                                                <textarea name="uraian" id="uraian" class="form-control" cols="30" rows="10" required>{{ $problem->uraian }}</textarea>
                                                    @error('uraian')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="alamat_kejadian" class="form-label">Alamat Kejadian</label>
                                                <textarea name="alamat_kejadian" id="alamat_kejadian" class="form-control" cols="30" rows="10" required>{{ $problem->alamat_kejadian }}</textarea>
                                                    @error('alamat_kejadian')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
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
