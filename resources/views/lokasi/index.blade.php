@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Lokasi</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kota_kabupaten">Kota / Kabupaten</label>
                            <select class="form-control" name="kota_kabupaten" id="kota_kabupaten">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select class="form-control" name="kecamatan" id="kecamatan">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelurahan_desa">Kelurahan / Desa</label>
                            <select class="form-control" name="kelurahan_desa" id="kelurahan_desa">
                                <option value="">Pilih Kelurahan / Desa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_jalan">Nama Jalan</label>
                            <select class="form-control select2" name="nama_jalan" id="nama_jalan">
                                <option value="">Pilih Jalan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- SELECT2 PLUGIN --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        // Base API
        const API = "https://dev.farizdotid.com/api/daerahindonesia";

        const getAPI = async (url) => {
            const response = await fetch(url);
            const data = await response.json();
            return data;
        }

        // FORM ELEMENT
        const formKota = document.querySelector('#kota_kabupaten');
        const formKecamatan = document.querySelector('#kecamatan');
        const formKelurahan = document.querySelector('#kelurahan_desa');
        const formJalan = document.querySelector('#nama_jalan');

        const newOptionElement = (parent, data) => {
            parent.innerHTML = '';
            const options = Array.isArray(data) ? data : [data];

            for (let data of options) {
                const newOption = document.createElement('option');
                newOption.value = data.id;
                newOption.innerText = data.nama;
                parent.append(newOption);
            }
        }

        window.addEventListener('DOMContentLoaded', async () => {
            const kota = await getAPI(`${API}/kota/1771`);
            newOptionElement(formKota, kota);

            const kecamatan = await getAPI(`${API}/kecamatan?id_kota=${formKota.value}`);
            newOptionElement(formKecamatan, kecamatan.kecamatan);

            const kelurahan = await getAPI(`${API}/kelurahan?id_kecamatan=${formKecamatan.value}`);
            newOptionElement(formKelurahan, kelurahan.kelurahan);
        });

        formKecamatan.addEventListener('change', (e) => {
            formKelurahan.setAttribute('disabled', 'true');
            if (e.target.value) {
                formKelurahan.removeAttribute('disabled');
                getAPI(`${API}/kelurahan?id_kecamatan=${formKecamatan.value}`)
                    .then(data => newOptionElement(formKelurahan, data.kelurahan));
            }
        });
    </script>
@endsection
