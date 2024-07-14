@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Barang Jenis</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahBarangJenisModal">
                Tambah Barang Jenis
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="barangJenisTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambahBarangJenisModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tambahBarangJenisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangJenisModalLabel">Tambah Barang Jenis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                      <label for="nama-jenis" class="col-form-label">Nama Jenis</label>
                      <input type="text" class="form-control" id="nama-jenis">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveBarangJenisBtn">Simpan</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBarangJenisModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editBarangJenisModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangJenisModalLabel">Edit Barang Jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="edit-nama-jenis" class="col-form-label">Nama Jenis</label>
                            <input type="text" class="form-control" id="edit-nama-jenis">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateBarangJenisBtn">Update</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#barangJenisTable").DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                lengthChange: false,
                ordering: false,
                ajax: `{{ route('barangjenis.get') }}`,
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
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
                                <button class="btn btn-sm btn-success editBtn" data-id="${row.id}">Ubah</button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${row.id}">Hapus</button>
                            `;
                        }
                    }
                ]
            });

            $('#barangJenisTable').on('click', '.editBtn', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: `/barangjenis/${id}/show`,
                    method: 'GET',
                    success: function (response) {
                        $('#editBarangJenisModal').modal('show');
                        $('#edit-nama-jenis').val(response.nama_jenis);
                        $('#updateBarangJenisBtn').data('id', id);
                    }
                });
            });

            $('#updateBarangJenisBtn').on('click', function () {
                let id = $(this).data('id');
                let namaJenis = $('#edit-nama-jenis').val();

                $.ajax({
                    type: "PUT",
                    url: `/barangjenis/${id}/update`,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama_jenis": namaJenis
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success) {
                            $('#editBarangJenisModal').modal('hide');
                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            )
                            $('#barangJenisTable').DataTable().ajax.reload();
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

            $('#saveBarangJenisBtn').on('click', function () { 
                let namaJenis = $('#nama-jenis').val()

                $.ajax({
                    type: "POST",
                    url: "{{ route('barangjenis.store') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama_jenis": namaJenis
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success) {
                            $('#nama-jenis').val("")
                            $('#tambahBarangJenisModal').modal('hide');
                            Swal.fire(
                                'Berhasil',
                                response.success,
                                'success'
                            )
                            $('#barangJenisTable').DataTable().ajax.reload();
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

            $('#barangJenisTable').on('click', '.deleteBtn', function () {
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
                            url: `/barangjenis/${id}/delete`,
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
                                    $('#barangJenisTable').DataTable().ajax.reload();
                                }
                            }
                        });
                    }
                })
            });
        });
    </script>
@endpush