@extends('layouts.landing.app')
@section('content')
    <div class="row position-relative">
        <form action="" method="GET" id="filter-peta" style="position: absolute; top:0;z-index:999; width:100%">
            <input type="text" class="form-control d-block shadow-lg" name="nama_jalan" placeholder="Cari Jalan.."
                autocomplete="off" value="{{ request('nama_jalan') ?? '' }}" autofocus
                style="max-width:700px; margin:1em auto;">
        </form>
        <div class="col-md-12">
            <div id="map" style="height:calc(100vh - 57px)"></div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const data = @json($data_kecelakaan);

        const popUpContent = (data) => {
            return `<strong class="mb-3 d-block">${data.lokasi.nama_jalan}</strong>
                    <table cellpadding="7" border="1" width="100%">
                        <thead class="text-center">
                            <tr>
                                <th>Tahun</th>
                                <th>Korban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">${data.tgl_kejadian}</td>
                                <td>
                                    <table cellpadding="3">
                                        <tr>
                                            <td>Luka Ringan</td>
                                            <td>:</td>
                                            <td>${data.luka_ringan}</td>
                                        </tr>
                                        <tr>
                                            <td>Luka Berat</td>
                                            <td>:</td>
                                            <td>${data.luka_berat}</td>
                                        </tr>
                                        <tr>
                                            <td>Meninggal</td>
                                            <td>:</td>
                                            <td>${data.meninggal}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>`;
        }
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
                // Marker Color Rules
                // markerBackground = markerRules(data[item]);

                const myMarker = customMarker(data[item]);
                var marker = new mapboxgl.Marker(myMarker)
                    .setLngLat([location.longitude, location.latitude])
                    .addTo(map);

                const popup = new mapboxgl.Popup({
                        closeOnClick: true
                    })
                    .setHTML(popUpContent(data[item]));

                marker.setPopup(popup);
            }
        });
    </script>
@endpush
