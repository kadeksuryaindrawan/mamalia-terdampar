@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Edit Tindakan</h5>
                                    <form method="POST" action="{{ route('tindakan-update',$tindakan->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="tindakan" class="form-label">Tindakan</label>
                                                <textarea name="tindakan" id="tindakan" class="form-control" cols="30" rows="10" required>{{ $tindakan->tindakan }}</textarea>
                                                    @error('tindakan')
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
