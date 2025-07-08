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
                            @foreach ($index as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kd_barang }}</td>
                                    <td>{{ $item->nm_barang }}</td>
                                    <td>active</td>`
                                    <td>{{ $item->sat_barang ?? '-' }}</td>
                                    <td>{{ $item->jenisobat }}</td>
                                    <td>{{ number_format($item->hrgsat_barang, 0, ',', '.') }}</td>
                                    <td>{{ number_format($item->hrgjual_barang, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-toggle="dropdown">
                                                Action
                                            </button>
                                            <div class="dropdown-menu p-2">
                                                <a href="#" class="btn btn-info btn-sm w-100 mb-1">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <a href="#" class="btn btn-warning btn-sm w-100 mb-1">
                                                    <i class="far fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="#"
                                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
        $(function() {
            $('#example1').DataTable({
                responsive: true,
                scrollX: true,
                autoWidth: false,
                lengthChange: true,
                paging: true,
                ordering: true,
                info: true,
                columnDefs: [{
                        targets: [0],
                        className: 'text-center',
                        width: '40px'
                    }, // No
                    {
                        targets: [8],
                        className: 'text-center',
                        width: '120px'
                    }, // Aksi
                ],
                language: {
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Data tidak ditemukan",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    search: "Cari:",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });
        });
    </script>
@endpush
