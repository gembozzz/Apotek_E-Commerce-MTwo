@extends('frontend.layouts.index')
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row row-equal">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Seluruh Produk</h2>
                    </div>
                </div>
                <!-- section title -->
                <!-- Search Form -->
                <div class="col-md-12 mb-4">
                    <form action="{{ route('produk.search') }}" method="GET" class="form-inline text-right">
                        <div class="form-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari produk..."
                                value="{{ request('q') }}" style="width: 250px;">
                            <button type="submit" class="btn btn-success ml-2">Cari</button>
                        </div>
                    </form>
                </div>

                <!-- Product Single -->
                <!-- Product Single -->
                @forelse ($produk as $item)
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product product-single" data-aos="fade-up" data-aos-duration="600">
                            <div class="product-thumb">
                                <a href="{{ route('produk.detail', $item->id_barang) }}">
                                    <button class="main-btn quick-view"><i class="fa fa-searchplus"></i> Detail
                                        Produk</button>
                                </a>
                                <img src="{{ asset('eshop/img/product01.jpg') }}" alt="">
                            </div>
                            <div class="product-body">
                                <h3 class="product-price">Rp{{ number_format($item->hrgjual_barang, 0, ',', '.') }}</h3>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                    <i class="fa fa-star-o empty"></i>
                                </div>
                                <h2 class="product-name"><a href="#">{{ $item->nm_barang }}</a></h2>
                                <div class="product-btns">
                                    <button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
                                    <button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to
                                        Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p class="text-center">Produk tidak ditemukan.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center">
                {{ $produk->links('pagination::bootstrap-4') }}
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
