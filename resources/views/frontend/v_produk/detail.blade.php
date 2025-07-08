@extends('frontend.layouts.index')
@section('content')
    <!-- template -->
    <!-- row -->
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Section Title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">{{ $judul }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Details -->
    <div class="product product-details clearfix">
        <div class="col-md-6">
            <div id="product-main-view">
                <div class="product-view">
                    {{-- Gambar utama dinonaktifkan --}}
                    {{-- <img src="{{ asset('storage/img-produk/thumb_lg_' . $row->foto) }}" alt=""> --}}
                </div>
            </div>
            <div id="product-view">
            </div>
        </div>
        <div class="col-md-6">
            <div class="product-body">
                <div class="product-label">
                    <span>Kategori</span>
                    <span class="sale">{{ $produks->jenisObat->jenisobat_label ?? '-' }}</span>
                </div>
                <h2 class="product-name">{{ $produks->nm_barang }}</h2>
                <h3 class="product-price">Rp. {{ number_format($produks->hrgjual_barang, 0, ',', '.') }}</h3>
                <p>
                    {!! $produks->indikasi !!}
                </p>
                <div class="product-options">
                    <ul class="size-option">
                        <li><span class="text-uppercase">Stok:</span></li>
                        {{ $produks->stok_barang }}
                    </ul>
                </div>
                <div class="product-btns">
                    {{-- Form pemesanan dinonaktifkan --}}
                    <form action="#" method="post" style="display: inline-block;">
                        @csrf
                        <button type="submit" class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i>
                            Pesan</button>
                    </form>
                    <a href="{{ route('home-page') }}">
                        <button type="submit" class="primary-btn">
                            Kembali</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <br>
    <!-- /Product Details -->
    <!-- end template-->
@endsection
