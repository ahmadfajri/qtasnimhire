@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangModal">
                Tambah Barang
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="barangTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Jenis</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahBarangModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="nama-barang" class="col-form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama-barang">
                            </div>

                            <div class="form-group">
                                <label for="jenis" class="col-form-label">Jenis</label>
                                <select name="jenis" id="jenis" class="form-control" style="width: 100%">
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($barangjenis as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="stok" class="col-form-label">Stok</label>
                                <input type="number" class="form-control" id="stok">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBarangBtn">Simpan</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBarangModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="edit-id" id="edit-id">
                                    <label for="edit-nama-barang" class="col-form-label">Nama Barang</label>
                                    <input type="text" class="form-control" id="edit-nama-barang">
                                </div>
    
                                <div class="form-group">
                                    <label for="edit-jenis" class="col-form-label">Jenis</label>
                                    <select name="edit-jenis" id="edit-jenis" class="form-control" style="width: 100%">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($barangjenis as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="form-group">
                                    <label for="edit-stok" class="col-form-label">Stok</label>
                                    <input type="number" class="form-control" id="edit-stok" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBarangBtn">Update</button>
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
        $(document).ready(function() {
            $('#jenis').select2({
                dropdownParent: $("#tambahBarangModal")
            });

            $('#edit-jenis').select2({
                dropdownParent: $("#editBarangModal")
            });

            $("#barangTable").DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                lengthChange: false,
                ordering: false,
                ajax: `{{ route('barang.get') }}`,
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
                        data: 'nama_jenis',
                        name: 'nama_jenis',
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                    },
                    {
                        data: null,
                        name: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-success editBtn" data-id="${row.id}">Ubah</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ]
            });

            $('#saveBarangBtn').on('click', function () { 
                let namaBarang = $('#nama-barang').val()
                let jenisBarang = $('#jenis').val()
                let stok = $('#stok').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('barang.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama_barang": namaBarang,
                        "jenis": jenisBarang,
                        "stok": stok
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success) {
                            $('#nama-barang').val("")
                            $('#stok').val("")
                            $('select[name="jenis"]').val(null).trigger('change')

                            $('#tambahBarangModal').modal('hide');
                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            )
                            $('#barangTable').DataTable().ajax.reload();
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

            $('#barangTable').on('click', '.editBtn', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: `/barang/${id}/show`,
                    method: 'GET',
                    success: function (response) {
                        $('#editBarangModal').modal('show');
                        $('#edit-id').val(response.id);
                        $('#edit-nama-barang').val(response.nama_barang);
                        $('select[name="edit-jenis"]').val(response.barang_jenis_id).trigger('change');
                        $('#edit-stok').val(response.stok);
                        $('#updateBarangBtn').data('id', id);
                    }
                });
            });

            $('#updateBarangBtn').on('click', function () {
                let id = $(this).data('id');
                let namaBarang = $('#edit-nama-barang').val()
                let jenisBarang = $('#edit-jenis').val()
                let stok = $('#edit-stok').val()

                $.ajax({
                    type: "PUT",
                    url: `/barang/${id}/update`,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama_barang": namaBarang,
                        "jenis": jenisBarang,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success) {
                            $('#editBarangModal').modal('hide');
                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            )
                            $('#barangTable').DataTable().ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
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
            });

            $('#barangTable').on('click', '.deleteBtn', function () {
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
                            url: `/barang/${id}/delete`,
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
                                    $('#barangTable').DataTable().ajax.reload();
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush