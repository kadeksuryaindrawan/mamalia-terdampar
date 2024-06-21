@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Tambah Masalah</h5>
                                    <form method="POST" action="{{ route('masalah.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="masalah" class="form-label">Masalah</label>
                                                <input type="text" class="form-control" name="masalah" id="masalah" placeholder="Masukkan Masalah" required>
                                                    @error('masalah')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="uraian" class="form-label">Uraian Masalah</label>
                                                <textarea name="uraian" id="uraian" class="form-control" cols="30" rows="10" required></textarea>
                                                    @error('uraian')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="alamat_kejadian" class="form-label">Alamat Kejadian</label>
                                                <textarea name="alamat_kejadian" id="alamat_kejadian" class="form-control" cols="30" rows="10" required></textarea>
                                                    @error('alamat_kejadian')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="image">Foto</label>
                                                <input type="file" id="image" class="filepond"
                                                    name="image" multiple credits="false" required>
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

    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);

        const inputElement = document.querySelector('input[type="file"]');

        const pond = FilePond.create(inputElement);

        FilePond.setOptions({
            acceptedFileTypes: ['image/*'],
            server: {
                process: '{{ route('uploadtemporaryproblem') }}',
                revert: '{{ route('deletetemporaryproblem') }}',
                headers:{
                    'X_CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
        });
    </script>
@endsection
