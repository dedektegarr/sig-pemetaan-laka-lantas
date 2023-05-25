@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div id="map" style="height:500px"></div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const data = @json($data_kecelakaan);

        $(document).ready(function() {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [102.263641, -3.792228],
                zoom: 11,
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.FullscreenControl());

            for (let item in data) {
                const location = data[item].lokasi;
                var marker = new mapboxgl.Marker()
                    .setLngLat([location.longitude, location.latitude])
                    .addTo(map);

                const popup = new mapboxgl.Popup({
                        closeOnClick: true
                    })
                    .setHTML(`<p>${location.nama_jalan}</p>`);

                marker.setPopup(popup);
            }
        });
    </script>
@endpush
