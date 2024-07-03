@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Penanganan Untuk {{ ucwords($problem->masalah) }}</h5>
                                    <form method="POST" action="{{ route('tindakan-store',$problem->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="tindakan" class="form-label">Penanganan</label>
                                                <textarea name="tindakan" id="tindakan" class="form-control" cols="30" rows="10" required></textarea>
                                                    @error('tindakan')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="image">Foto Bukti</label>
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
                process: '{{ route('uploadtemporarytindakan') }}',
                revert: '{{ route('deletetemporarytindakan') }}',
                headers:{
                    'X_CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
        });
    </script>
@endsection
