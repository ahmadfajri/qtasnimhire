@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <form class="d-flex">
                        <input type="text" name="search_nama_barang" id="search_nama_barang" class="form-control mr-2" placeholder="Cari Nama Barang..." value="{{ request()->search_nama_barang ?? '' }}">
                        <select name="urut_nama_barang" id="urut_nama_barang" class="form-control mr-2">
                            <option value="">Urutkan Nama Barang</option>
                            <option value="ASC">A-Z</option>
                            <option value="DESC">Z-A</option>
                        </select>
                        <script>
                            document.getElementsByName('urut_nama_barang')[0].value = "{{ request()->urut_nama_barang }}"
                        </script>
                        <select name="urut_tgl_transaksi" id="urut_tgl_transaksi" class="form-control mr-2">
                            <option value="">Urutkan Tgl Transaksi</option>
                            <option value="ASC">Terlama</option>
                            <option value="DESC">Terbaru</option>
                        </select>
                        <script>
                            document.getElementsByName('urut_tgl_transaksi')[0].value = "{{ request()->urut_tgl_transaksi }}"
                        </script>
                        <button class="btn btn-success">Cari</button>
                    </form>
                </div>

                <div class="col-md-3">
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#tambahTransaksiModal">
                        Tambah Transaksi
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="transaksiTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Jumlah Terjual</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahTransaksiModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahTransaksiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTransaksiModalLabel">Tambah Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="barang" class="col-form-label">Barang</label>
                                <select name="barang" id="barang" class="form-control" style="width: 100%" onchange="pilihBarang(event)">
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stok" class="col-form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" readonly>
                            </div>

                            <div class="form-group">
                                <label for="jenis" class="col-form-label">Jenis</label>
                                <input type="text" class="form-control" id="jenis" readonly>
                            </div>

                            <div class="form-group">
                                <label for="jumlah-terjual" class="col-form-label">Jumlah Terjual</label>
                                <input type="number" class="form-control" id="jumlah-terjual">
                            </div>

                            <div class="form-group">
                                <label for="tgl-transaksi" class="col-form-label">Tanggal Transaksi</label>
                                <input type="date" class="form-control" id="tgl-transaksi">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTransaksiBtn">Simpan</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@push('prepend-style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush


@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function pilihBarang(event) { 
            let id = event.target.value
            if(id){
                $.ajax({
                    type: 'GET',
                    url: `/barang/${id}/show`,
                    success: function (response) {
                        $("#stok").val(response.stok)
                        $("#jenis").val(response.nama_jenis)
                    }
                });
            }else{
                $("#stok").val("");
                $("#jenis").val("");
            }
        }

        $(document).ready(function() {
            $('#barang').select2({
                dropdownParent: $("#tambahTransaksiModal")
            });

            $('#edit-jenis').select2({
                dropdownParent: $("#editBarangModal")
            });

            let queryString = window.location.search
            let urlParams = new URLSearchParams(queryString);

            let searchNamaBarang = urlParams.get('search_nama_barang');
            let urutNamaBarang = urlParams.get('urut_nama_barang');
            let urutTglTransaksi = urlParams.get('urut_tgl_transaksi');

            $('#urut_nama_barang').change(function (e) { 
                e.preventDefault();
                $('#urut_tgl_transaksi').val("")
            });

            $('#urut_tgl_transaksi').change(function (e) { 
                e.preventDefault();
                $('#urut_nama_barang').val("")
            });

            $("#transaksiTable").DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                lengthChange: false,
                ordering: false,
                ajax: {
                    "url": "{{ route('transaksi.get') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        'search_nama_barang' : searchNamaBarang,
                        'urut_nama_barang' : urutNamaBarang,
                        'urut_tgl_transaksi' : urutTglTransaksi,
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang',
                    },
                    {
                        data: 'current_stok',
                        name: 'current_stok',
                    },
                    {
                        data: 'jumlah_terjual',
                        name: 'jumlah_terjual',
                    },
                    {
                        data: 'tgl_transaksi',
                        name: 'tgl_transaksi',
                    },
                    {
                        data: 'nama_jenis',
                        name: 'nama_jenis',
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ]
            });

            $('#saveTransaksiBtn').on('click', function () { 
                let tglTransaksi = $('#tgl-transaksi').val()
                let barang = $('#barang').val()
                let stok = $('#stok').val()
                let jumlahTerjual = $('#jumlah-terjual').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('transaksi.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tgl_transaksi": tglTransaksi,
                        "barang": barang,
                        "stok": stok,
                        "jumlah_terjual": jumlahTerjual
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success) {
                            $('select[name="barang"]').val(null).trigger('change')
                            $('#stok').val("")
                            $('#jenis').val("")
                            $('#jumlah-terjual').val("")
                            $('#tgl-transaksi').val("")

                            $('#tambahTransaksiModal').modal('hide');

                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            )
                            $('#transaksiTable').DataTable().ajax.reload();
                        }
                    },
                    error: function (xhr) { 
                        let errors = xhr.responseJSON.errors
                        let errorMessage = ''
                        for (let key in errors) {
                            if(errors.hasOwnProperty(key)) {
                                errorMessage += errors[key] + '<br>';
                            }
                        }
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        )
                    }
                });
            })

            $('#transaksiTable').on('click', '.deleteBtn', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus itu!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `/transaksi/${id}/delete`,
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if(response.success) {
                                    Swal.fire(
                                        'Deleted!',
                                        response.success,
                                        'success'
                                    )
                                    $('#transaksiTable').DataTable().ajax.reload();
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush