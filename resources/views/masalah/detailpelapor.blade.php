@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Detail {{ __('messages.report') }}</h4>
                                    <p>{{ __('messages.reporter') }} : {{ ucwords($problem->user->nama) }}</p>
                                    <p>{{ __('messages.report') }} : {{ ucwords($problem->masalah) }}</p>
                                    <p>{{ __('messages.description') }} {{ __('messages.report') }} : {{ ucfirst($problem->uraian) }}</p>
                                    <p>{{ __('messages.incident_location') }} : </p>
                                    <div class="col-lg-12 mb-5">
                                        <div id="map" style="width: 100%;height: 300px;border-radius: 10px;z-index: 1;"></div>
                                    </div>
                                    <p>{{ __('messages.incident') }} : {{ ucfirst($problem->alamat_kejadian) }}</p>
                                    <p>Status : @if ($problem->status == 'belum ditangani')
                                                                <span class="badge bg-danger text-danger">{{ __('messages.not_handled') }}</span>
                                                            @elseif($problem->status == 'proses penanganan')
                                                                <span class="badge bg-warning text-warning">{{ __('messages.handling_process') }}</span>
                                                            @else
                                                                <span class="badge bg-success text-success">{{ __('messages.completed_handled') }}</span>
                                                            @endif</p>
                                    <p>{{ __('messages.reported_on') }} : {{ date("d M Y H:i:s",strtotime($problem->created_at)) }}</p>
                                    <p>{{ __('messages.edited_on') }} : {{ date("d M Y H:i:s",strtotime($problem->updated_at)) }}</p>
                                    <p>{{ __('messages.image') }} : </p>
                                    @foreach ($images as $image)
                                        <a class="example-image-link"
                                        href="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" data-lightbox="example-1">
                                        <img style="width: 120px; height:100px; object-fit:cover;" src="{{ asset('images/problem/'.$image->folder.'/'.$image->name) }}" alt=""></a>
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

        let layer = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);

        var latlong = L.marker([{{ $problem->latitude }}, {{ $problem->longitude }}]);

        latlong.addTo(map).bindPopup("<b>{{ ucwords($problem->masalah) }}</b><br><p>{{ ucfirst($problem->uraian) }}</p><a target='_BLANK' href='https://www.google.com/maps?q={{ $problem->latitude }}, {{ $problem->longitude }}'><button class='btn btn-primary btn-sm'>Google Maps</button></a>");


    </script>

@endsection
