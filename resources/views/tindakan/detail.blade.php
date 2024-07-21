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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Data Laporan</h4> <br>
                                    <p>Pelapor : {{ ucwords($problem->user->nama) }}</p>
                                    <p>Laporan : {{ ucwords($problem->masalah) }}</p>
                                    <p>Uraian Laporan : {{ ucfirst($problem->uraian) }}</p>
                                    <p>Lokasi Kejadian : </p>
                                    <div class="col-lg-12 mb-5">
                                        <div id="map" style="width: 100%;height: 300px;border-radius: 10px;z-index: 1;"></div>
                                    </div>
                                    <p>Detail Lokasi Kejadian : {{ ucfirst($problem->alamat_kejadian) }}</p>
                                    <p>Dilaporkan Pada : {{ date("d M Y H:i:s",strtotime($problem->created_at)) }}</p>
                                    <p>Status : @if ($problem->status == 'belum ditangani')
                                                                <span class="badge bg-danger text-danger">{{ ucwords($problem->status) }}</span>
                                                            @elseif($problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ ucwords($problem->status) }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ ucwords($problem->status) }}</span>
                                                            @endif</p>
                                    @if ($problem->status == 'selesai ditangani')
                                        <p>File : <a target="__BLANK" href="{{ asset('file/'.$problem->file) }}"><button class="btn btn-primary">Lihat File</button></a></p>
                                    @endif
                                    <p>Foto Laporan : </p>
                                    @foreach ($problem_images as $image)
                                        <a class="example-image-link"
                                        href="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" data-lightbox="example-1">
                                        <img style="width: 120px; height:100px; object-fit:cover;" src="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" alt=""></a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Daftar Penanganan Yang Sudah Dilakukan</h4> <br>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($tindakans as $tindakan)
                                        <strong><p>Penanganan ke-{{ $no++ }}</p></strong>
                                        <p>Dilakukan Penanganan Pada : {{ date("d M Y H:i:s",strtotime($tindakan->created_at)) }}</p>
                                        <p>Penanganan : {{ ucfirst($tindakan->tindakan) }}</p>
                                        <p>Dilakukan Penanganan Oleh : {{ ucwords($tindakan->oleh) }}</p>
                                        <p>Foto Bukti Penanganan : </p>
                                        @foreach ($tindakan_images[$tindakan->id] as $image)
                                            <a class="example-image-link"
                                            href="{{ asset('images/tindakan/'.$image->folder.'/'.$image->name) }}" data-lightbox="example-1">
                                            <img style="width: 120px; height:100px; object-fit:cover;" src="{{ asset('images/tindakan/'.$image->folder.'/'.$image->name) }}" alt=""></a>
                                        @endforeach
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan')
                                            <br><br>
                                            <a href="{{ route('tindakan-edit',$tindakan->id) }}"><button class="btn btn-primary">Edit</button></a>
                                            <a href="{{ route('editfototindakan',$tindakan->id) }}"><button class="btn btn-secondary">Edit Foto</button></a>
                                            <form action="{{ route('tindakan-destroy',$tindakan->id) }}" method="post" onsubmit="return confirm('Yakin hapus penanganan?')" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger"> Hapus</button>
                                            </form>
                                        @endif
                                        <br><br>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

    <script>
        let mapOptions = {
            center:[{{ $problem->latitude }}, {{ $problem->longitude }}],
            zoom:14
        }

        let map = new L.map('map' , mapOptions);

        let layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);

        var latlong = L.marker([{{ $problem->latitude }}, {{ $problem->longitude }}]);

        latlong.addTo(map).bindPopup("<b>{{ ucwords($problem->masalah) }}</b><br><p>{{ ucfirst($problem->uraian) }}</p><a target='_BLANK' href='https://www.google.com/maps?q={{ $problem->latitude }}, {{ $problem->longitude }}'><button class='btn btn-primary btn-sm'>Lihat Pada Maps</button></a>");


    </script>

@endsection
