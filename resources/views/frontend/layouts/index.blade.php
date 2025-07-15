<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>E-SHOP HTML Template</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Di bagian <head> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ asset('eshop/css/bootstrap.min.css') }}" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{ asset('eshop/css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('eshop/css/slick-theme.css') }}" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{ asset('eshop/css/nouislider.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ asset('eshop/css/font-awesome.min.css') }}">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('eshop/css/style.css') }}" />
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <style>
        .menu-list a.active {
            font-weight: bold;
            color: #3ea110;
            border-bottom: 2px solid #3ea110;
        }
    </style>

</head>

<body>
    <!-- HEADER -->
    <header>
        <!-- top Header -->
        <div id="top-header">
            <div class="container">
                <div class="pull-left">
                    <span>Welcome to E-shop!</span>
                </div>
            </div>
        </div>
        <!-- /top Header -->

        <!-- header -->
        <div id="header">
            <div class="container">
                <div class="pull-left">
                    <!-- Logo -->
                    <div class="header-logo">
                        <a class="logo" href="#">
                            <img src="{{ asset('eshop/img/image.png') }}" alt="">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Search -->
                    <!-- /Search -->
                </div>
                <div class="pull-right">
                    <ul class="header-btns">
                        <!-- Account -->
                        <li class="header-account dropdown default-dropdown">
                            <div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
                                <div class="header-btns-icon">
                                    <i class="fa fa-user-o"></i>
                                </div>
                                <strong class="text-uppercase">My Account <i class="fa fa-caret-down"></i></strong>
                            </div>
                            @if (Auth::check())
                                <a href="#" class="text-uppercase">{{ Auth::user()->name }}</a>
                                <ul class="custom-menu list-unstyled">
                                    <li>
                                        <a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}">
                                            <i class="fa fa-user-o me-2"></i> My Account
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('order.history') }}">
                                            <i class="fa fa-shopping-cart me-2"></i> History Pemesanan
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                            <i class="fa fa-unlock-alt me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>

                                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <ul class="custom-menu">
                                    <li><a href="{{ route('login.form') }}"><i class="fa fa-unlock-alt"></i> Login</a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        <!-- /Account -->

                        <!-- Cart -->
                        <li class="header-cart dropdown default-dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <div class="header-btns-icon">
                                    <a href="{{ route('order.cart') }}">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="qty">{{ $cartCount }}</span>
                                    </a>
                                </div>
                                <strong class="text-uppercase">My Cart:</strong>
                                <br>
                                <span style="font-size: 12px">Rp. {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </a>
                        </li>
                        <!-- /Cart -->

                        <!-- Mobile nav toggle-->
                        <li class="nav-toggle">
                            <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                        </li>
                        <!-- / Mobile nav toggle -->
                    </ul>
                </div>
            </div>
            <!-- header -->
        </div>
        <!-- container -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <div id="navigation">
        <!-- container -->
        <div class="container">
            <div id="responsive-nav">
                @if (request()->segment(1) == '' || request()->segment(1) == 'home-page')
                    <!-- category nav -->
                    <div class="category-nav">
                        <span class="category-header" onclick="toggleKategoriList()" style="cursor: pointer;">
                            Kategori <i class="fa fa-list"></i>
                        </span>
                        <ul class="category-list" id="kategori-list" style="display: none;">
                            @foreach ($kategori as $item)
                                <li>
                                    <a
                                        href="{{ route('produk.kategori', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="category-nav show-on-click">
                        <span class="category-header">Kategori <i class="fa fa-list"></i></span>
                        <ul class="category-list">
                            @foreach ($kategori as $item)
                                <li>
                                    <a
                                        href="{{ route('produk.kategori', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- /category nav -->

                <!-- menu nav -->
                <div class="menu-nav">
                    <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
                    <ul class="menu-list">
                        <li>
                            <a href="{{ route('home-page') }}"
                                class="{{ request()->routeIs('home-page') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('produk.all') }}"
                                class="{{ request()->routeIs('produk.all') ? 'active' : '' }}">
                                All Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('artikel.all') }}"
                                class="{{ request()->routeIs('artikel.all', 'article.show') ? 'active' : '' }}">
                                Artikel
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- menu nav -->
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /NAVIGATION -->

    @yield('content')

    <!-- FOOTER -->
    <footer id="footer" class="section section-grey">
        <!-- container -->
        <div class="container">
            <hr>
            <!-- row -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <!-- footer copyright -->
                    <div class="footer-copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | BRIGHT FUTURE
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </div>
                    <!-- /footer copyright -->
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script>
        function toggleKategoriList() {
            const list = document.getElementById('kategori-list');
            list.style.display = (list.style.display === 'none' || list.style.display === '') ? 'block' : 'none';
        }
    </script>
    <script src="{{ asset('eshop/js/jquery.min.js') }}"></script>
    <script src="{{ asset('eshop/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('eshop/js/slick.min.js') }}"></script>
    <script src="{{ asset('eshop/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('eshop/js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('eshop/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>

</body>

</html>
