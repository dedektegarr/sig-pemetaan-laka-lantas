@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div id="map" style="height:500px"></div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tahun</th>
                <th>Luka Ringan</th>
                <th>Luka Berat</th>
                <th>Meninggal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2020</td>
            </tr>
        </tbody>
    </table>
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
                                <td class="text-center">2020</td>
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
                var marker = new mapboxgl.Marker()
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
