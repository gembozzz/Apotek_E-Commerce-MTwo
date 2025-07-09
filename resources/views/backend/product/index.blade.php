@extends('backend.layouts.app')

@section('title', 'Produk')

@section('header', 'Halaman Data Produk')

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Produk</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-auto table-sm table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                            <th>Satuan</th>
                            <th>Jenis Obat</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection

@push('css')
@endpush

@push('scripts')
<script>
    $(function () {
        $('#example1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('backend.product.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kd_barang', name: 'kd_barang' },
                { data: 'nm_barang', name: 'nm_barang' },
                { data: 'status', name: 'status' },
                { data: 'sat_barang', name: 'sat_barang' },
                { data: 'jenisobat', name: 'jenisobat' },
                { data: 'hrgsat_barang', name: 'hrgsat_barang', render: $.fn.dataTable.render.number('.', ',', 0) },
                { data: 'hrgjual_barang', name: 'hrgjual_barang', render: $.fn.dataTable.render.number('.', ',', 0) },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush