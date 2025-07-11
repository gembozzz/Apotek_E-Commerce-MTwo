@extends('backend.layouts.app')

@section('title', 'Detail Customer')
@section('header', 'Detail Data Customer')

@section('content')
<section class="content">
    <div class="col-8 container-fluid">
        <div class="card card-primary shadow">
            <div class="card-header">
                <h3 class="card-title">Informasi Customer</h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $customer->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $customer->email }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $customer->telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $customer->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
</section>
@endsection