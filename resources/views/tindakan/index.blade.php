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
                                        <h4>Daftar Penanganan</h4>
                                    </div>
                                    <div style="overflow-x: scroll">
                                        <table id="zero-conf" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Laporan</th>
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
                                                                        <a href="{{ route('tindakan-detail',$tindakan->problem_id) }}" class="dropdown-item">Lihat Daftar Penanganan</a>
                                                                        <a href="{{ route('tindakan-terakhir',$tindakan->problem_id) }}" class="dropdown-item">Lihat Penanganan Terakhir</a>
                                                                        @if (Auth::user()->role == 'yayasan' || Auth::user()->role == 'admin')
                                                                            @if ($tindakan->problem->status == 'proses penanganan')
                                                                                <a href="{{ route('tindakan-create',$tindakan->problem_id) }}" class="dropdown-item">Update Penanganan Selanjutnya</a>
                                                                                <a href="#" onclick="openFileModal({{ $tindakan->problem_id }})" class="dropdown-item">Selesaikan Penanganan</a>
                                                                                {{-- <form action="{{route('tindakan-selesai',$tindakan->problem_id)}}" method="post" onsubmit="return confirm('Pastikan terlebih dahulu penanganan anda sudah sepenuhnya selesai dilakukan! Jika anda menyelesaikan penanganan, maka anda tidak dapat melakukan update tindakan selanjutnya! Apakah anda yakin ingin menyelesaikan penanganan? ')">
                                                                                    @csrf
                                                                                    @method('put')
                                                                                    <button class="dropdown-item" style="margin-left: -20px; margin-top:-10px;"> Selesaikan Penanganan</button>
                                                                                </form> --}}
                                                                            @endif
                                                                        @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal file -->
                                                    <div class="modal fade" id="file-modal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg d-flex justify-content-center">
                                                            <div class="modal-content w-75">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel1">Upload File</h5>
                                                                    <a onclick="closeFileModal()" style="cursor: pointer;"><i class="fas fa-times"></i></a>
                                                                </div>
                                                                <div class="modal-body p-4">
                                                                    <form method="POST" action="{{route('tindakan-selesai')}}" enctype="multipart/form-data" onsubmit="return confirm('Pastikan terlebih dahulu penanganan anda sudah sepenuhnya selesai dilakukan! Jika anda menyelesaikan penanganan, maka anda tidak dapat melakukan update penanganan selanjutnya! Apakah anda yakin ingin menyelesaikan penanganan? ')">
                                                                        @csrf
                                                                        @method('PUT')

                                                                        <input type="hidden" name="problem_id" id="problem_id" value="">
                                                                        <div class="form-outline mb-4">
                                                                            <label class="form-label" for="keterangan">Upload File (pdf)</label>
                                                                            <input type="file" name="file" id="" class="form-control" required>
                                                                        </div>

                                                                        <!-- Submit button -->
                                                                        <button type="submit" class="btn btn-primary btn-block">Selesaikan Penanganan</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal -->
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

    <script>
        function openFileModal(problem_id) {
            document.getElementById('problem_id').value = problem_id;
            $('#file-modal').modal('show');
        }
        function closeFileModal(){
            $('#file-modal').modal('hide');
        }
    </script>

@endsection
