@extends('frontend.layouts.index')
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row row-equal">
                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                <!-- section title -->
                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h2 class="title">Seluruh Produk</h2>
                        </div>

                        <!-- section title -->
                        <!-- Search Form -->
                        <div class="col-md-12 mb-4">
                            <form action="{{ route('produk.search') }}" method="GET">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="flex-grow-1">
                                        <input type="text" name="q" class="form-control"
                                            placeholder="Cari produk..." value="{{ request('q') }}">
                                        <br>
                                        <button type="submit" class="btn btn-success w-100 w-sm-auto">Cari</button>
                                    </div>
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
                                            <button class="main-btn quick-view"><i class="fa fa-search-plus"></i>
                                                Detail</button>
                                        </a>
                                        <img src="{{ asset('storage/' . ($item->image ?? 'default.png')) }}" alt="">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-price">Rp{{ number_format($item->hrgjual_barang, 0, ',', '.') }}
                                        </h3>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i><i class="fa fa-star"></i>
                                            <i class="fa fa-star-o empty"></i>
                                        </div>
                                        <h2 class="product-name"><a href="#">{{ $item->nm_barang }}</a></h2>
                                        <div class="product-btns">
                                            <form action="{{ route('order.addToCart', $item->id_barang) }}" method="post"
                                                style="display: inline-block;" title="Pesan Ke Aplikasi">
                                                @csrf
                                                <button type="submit" class="primary-btn add-to-cart"><i
                                                        class="fa fa-shopping-cart"></i> Add to cart</button>
                                                <input type="hidden" name="redirect" value="0">
                                            </form>
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
                </div>
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
