@extends('frontend.layouts.index')
@section('content')
    <!-- HOME -->
    <div id="home">
        <!-- container -->
        <div class="container">
            <!-- home wrap -->
            <div class="home-wrap">
                <!-- home slick -->
                <div id="home-slick">
                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('eshop/img/banner01.jpg') }}" alt="">
                        <div class="banner-caption text-center">
                            <h1>Bags sale</h1>
                            <h3 class="white-color font-weak">Up to 50% Discount</h3>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('eshop/img/banner02.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">Up to 50%
                                    OFF</span></h1>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->

                    <!-- banner -->
                    <div class="banner banner-1">
                        <img src="{{ asset('eshop/img/banner03.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h1 class="white-color">New Product <span>Collection</span></h1>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                    <!-- /banner -->
                </div>
                <!-- /home slick -->
            </div>
            <!-- /home wrap -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOME -->


    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Produk Terlaris</h2>
                        <div class="pull-right">
                            <div class="product-slick-dots-2 custom-dots">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- section title -->
                <!-- banner -->
                <div class="col-md-3 col-sm-6 col-xs-6">
                    <div class="banner banner-2">
                        <img src="{{ asset('eshop/img/banner20.jpg') }}" alt="">
                        <div class="banner-caption">
                            <h2 class="black-color">Produk<br>Terlaris</h2>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                </div>
                <!-- /banner -->
                <!-- Product Slick -->
                <div class="col-md-9 col-sm-6 col-xs-6">
                    <div class="row">
                        <div id="product-slick-2" class="product-slick">
                            <!-- Product Single -->
                            @foreach ($produkpalingbanyakterjual as $item)
                                <div class="product product-single">
                                    <div class="product-thumb">
                                        <a href="{{ route('produk.detail', $item->id_barang) }}">
                                            <button class="main-btn quick-view"><i class="fa fa-search-plus"></i>
                                                Detail</button>
                                        </a>
                                        <img src="{{ asset('eshop/img/product01.jpg') }}" alt="">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-price">Rp{{ number_format($item->hrgjual_barang, 0, ',', '.') }}
                                        </h3>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
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
                            @endforeach
                            <!-- /Product Single -->
                        </div>
                    </div>
                </div>
                <!-- /Product Slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- section title -->
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">Produk Terbaru</h2>
                    </div>
                </div>
                <!-- section title -->

                <!-- Product Single -->
                @foreach ($produkTerbaru as $item)
                    <div class="col-md-3 col-sm-6 col-xs-6">
                        <div class="product product-single">
                            <div class="product-thumb">
                                <a href="{{ route('produk.detail', $item->id_barang) }}">
                                    <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Detail</button>
                                </a>
                                <img src="{{ asset('storage/' . ($item->image ?? 'default.png')) }}" alt="">
                            </div>
                            <div class="product-body">
                                <h3 class="product-price">Rp{{ number_format($item->hrgjual_barang, 0, ',', '.') }}</h3>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
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
                @endforeach
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection
