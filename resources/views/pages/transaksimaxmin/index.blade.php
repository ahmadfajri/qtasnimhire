@extends('layout.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi Per Jenis</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <form class="d-flex">
                        <input type="date" class="form-control mr-3" name="dari" id="dari" value="{{ request()->dari != '' ? request()->dari : date('Y-m-d') }}">

                        <span class="mx-3 align-self-center">s/d</span>

                        <input type="date" class="form-control mr-3" name="sampai" id="sampai" value="{{ request()->sampai != '' ? request()->sampai : date('Y-m-d')}}">

                        <button class="btn btn-success">Cari</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="transaksimaxminTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Barang</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@push('addon-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            let queryString = window.location.search
            let urlParams = new URLSearchParams(queryString);

            let dari = $('#dari').val();
            let sampai = $('#sampai').val();

            $("#transaksimaxminTable").DataTable({
                processing: false,
                serverSide: false,
                searching: false,
                lengthChange: false,
                ordering: false,
                ajax: {
                    "url": "{{ route('transaksiperjenis.get') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        'dari' : dari,
                        'sampai' : sampai,
                    }
                },
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
                        data: 'total_terjual',
                        name: 'total_terjual',
                    },
                ]
            });
        });
    </script>
@endpush