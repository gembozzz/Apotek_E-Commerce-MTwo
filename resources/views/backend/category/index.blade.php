@extends('backend.layouts.app')

@section('title', 'Kategori')

@section('header', 'Halaman Data Kategori')

@section('content')
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Kategori</h3>
            </div>

            <div class="card-body">
                <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </a>
                <table id="example1" class="table table-auto table-sm table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
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
            ajax: "{{ route('backend.category.data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush