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
                @foreach ($banners as $banner)
                <div class="banner banner-1">
                    <img src="{{ asset('storage/' . $banner->foto) }}" alt="{{ $banner->judul }}">
                </div>
                @endforeach
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
                    <h2 class="title">Produk Diskon</h2>
                    <div class="pull-right">
                        <div class="product-slick-dots-2 custom-dots">
                        </div>
                    </div>
                </div>
            </div>
            <!-- section title -->
            <!-- Product Slick -->
            <div class="col-md-12">
                <div class="row">
                    <div id="product-slick-2" class="product-slick">
                        <!-- Product Single -->
                        @foreach ($diskonbarang as $item)
                        <div class="product product-single product-hot">
                            <div class="product-thumb">
                                <div class="product-label">
                                    <span class="sale">-{{ $item->diskon }}%</span>
                                </div>
                                <a href="{{ route('produk.detail', $item->id_barang) }}">
                                    <button class="main-btn quick-view"><i class="fa fa-search-plus"></i>
                                        Detail</button>
                                </a>
                                <img src="{{ asset('storage/' . ($item->image ?? 'default.png')) }}" alt="">
                            </div>
                            <div class="product-body">
                                <h3 class="product-price">
                                    Rp.{{ number_format($item->hrgjual_barang - ($item->hrgjual_barang * $item->diskon)
                                    / 100, 0, ',', '.') }}
                                    <del class="product-old-price">Rp.{{ number_format($item->hrgjual_barang, 0, ',',
                                        '.') }}</del>
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
                    <div class="pull-right">
                        <div class="product-slick-dots-3 custom-dots">
                        </div>
                    </div>
                </div>
            </div>
            <!-- section title -->
            <!-- Product Slick -->
            <div class="col-md-12">
                <div class="row">
                    <div id="product-slick-3" class="product-slick">
                        <!-- Product Single -->
                        @foreach ($databarang as $item)
                        <div class="product product-single product-hot">
                            <div class="product-thumb">
                                <div class="product-label">
                                    <span>NEW</span>
                                </div>
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
                    <h2 class="title">Artikel Terbaru</h2>
                </div>
            </div>
            <!-- section title -->

            <!-- Product Single -->
            @foreach ($articles as $article)
            <div class="col-md-4 col-sm-6 col-xs-12" data-aos="fade-up">
                <div class="product product-single d-flex flex-column shadow"
                    style="height: 100%; display: flex; border-radius: 8px; overflow: hidden; transition: 0.3s;">
                    <div class="product-thumb" style="overflow: hidden;">
                        <a href="{{ route('article.show', $article->slug) }}">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                style="height: 200px; width: 100%; object-fit: cover; border-radius: 8px 8px 0 0;">
                        </a>
                    </div>
                    <div class="product-body d-flex flex-column"
                        style="flex: 1; padding: 15px; background-color: #fff;">
                        <h3 class="product-price" style="min-height: 60px;">
                            {{ Str::limit($article->title, 60) }}
                        </h3>
                        <p class="product-name" style="flex: 1;">
                            {{ Str::limit(strip_tags($article->content), 100) }}
                        </p>
                        <a href="{{ route('article.show', $article->slug) }}" class="primary-btn btn-sm mt-auto"
                            style="border-radius: 6px;">
                            Baca Selengkapnya
                        </a>
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