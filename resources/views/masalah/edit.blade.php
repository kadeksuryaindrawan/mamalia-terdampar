@extends('layouts.app')

@section('content')
    <div class="page-content">
                <div class="main-wrapper">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Form Edit Laporan</h5>
                                    <form method="POST" action="{{route('laporan.update',$problem->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="masalah" class="form-label">Laporan</label>
                                                <input type="text" class="form-control" value="{{ $problem->masalah }}" name="masalah" id="masalah" placeholder="Masukkan Masalah" required>
                                                    @error('masalah')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="uraian" class="form-label">Uraian Laporan</label>
                                                <textarea name="uraian" id="uraian" class="form-control" cols="30" rows="10" required>{{ $problem->uraian }}</textarea>
                                                    @error('uraian')
                                                        <div class="text-danger text-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="longitude">Longitude</label>
                                                    <input type="text" id="longitude" class="form-control"
                                                        name="longitude" placeholder="Longitude" value="{{ $problem->longitude }}" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="latitude">Latitude</label>
                                                    <input type="text" id="latitude" class="form-control"
                                                        name="latitude" placeholder="Latitude" value="{{ $problem->latitude }}" readonly required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-3">
                                                <button type="button" class="btn btn-secondary" onclick="useCurrentLocation()">Gunakan Lokasi Saat Ini</button>
                                            </div>
                                            <div class="col-lg-12 mb-3"  style="z-index: 1;">
                                                <div id="map" style="width: 100%;height: 500px;border-radius: 10px;"></div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                <label for="alamat_kejadian" class="form-label">Detail Lokasi Kejadian</label>
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

    <script>

        let mapOptions = {
            center:[{{ $problem->latitude }}, {{ $problem->longitude }}],
            zoom:14
        }

        let map = new L.map('map' , mapOptions);

        let layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        map.addLayer(layer);
        // let geocoder = L.Control.geocoder().addTo(map);

        var latlong = L.marker([{{ $problem->latitude }}, {{ $problem->longitude }}]).addTo(map);

        let marker = null;

        function setMarker(lat, lng) {
            if (marker !== null) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        map.on('click', (event) => {
            map.removeLayer(latlong);
            // document.querySelector('.leaflet-control-geocoder-form input').value = '';
            setMarker(event.latlng.lat, event.latlng.lng);
        });

        L.Control.geocoder({
        defaultMarkGeocode: false
        }).on('markgeocode', function (event) {
            let latlng = event.geocode.center;
            map.removeLayer(latlong);
            setMarker(latlng.lat, latlng.lng);
        }).addTo(map);

        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.removeLayer(latlong);
                    setMarker(lat, lng);
                    map.setView([lat, lng], 14);
                }, (error) => {
                    alert('Error: ' + error.message);
                });
            } else {
                alert('Geolocation is not supported by this browser.');
            }
        }
    </script>

@endsection
