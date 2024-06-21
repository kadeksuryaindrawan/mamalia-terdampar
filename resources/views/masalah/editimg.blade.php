@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{$error}}
                            </div>
                            @endforeach
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Edit Foto Masalah</h5>
                                    <form method="POST" action="{{ route('editfotomasalahproses',$problem->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="image">Foto</label>
                                                <input type="file" id="image" class="filepond"
                                                    name="image" multiple credits="false">
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
