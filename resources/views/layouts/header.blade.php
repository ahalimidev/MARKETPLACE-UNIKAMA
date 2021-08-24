<header class="header header-intro-clearance header-4">

    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ route('index') }}" class="logo">
                    <img src="assets/images/demos/demo-4/logo.png" alt="Molla Logo" width="105" height="25">
                </a>
            </div><!-- End .header-left -->

            <div class="header-center">
                <div class="header-search header-search-extended header-search-visible d-none d-lg-block">
                    <form>
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Search</label>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            <input type="search" class="form-control" name="keyword"
                                placeholder="Search product ..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div>
            @if (session()->has('login_user'))
                <div class="header-right">
                    <div class="wishlist">
                        <a href="wishlist.html" title="Wishlist">
                            <div class="icon">
                                <i class="icon-cart-arrow-down"></i>
                            </div>
                            <p>Keranjang</p>
                        </a>
                    </div>

                    <div class="wishlist">
                        <a href="{{ route('profil') }}" title="Wishlist">
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                            <p>Profil</p>
                        </a>
                    </div>
                </div><!-- End .header-right -->
            @else
            <div class="header-right">
                <div class="wishlist">
                    <a href="{{ route('login') }}" title="Wishlist">
                        <div class="icon">
                            <i class="icon-cart-arrow-down"></i>
                        </div>
                        <p>Keranjang</p>
                    </a>
                </div>

                <div class="wishlist">
                    <a href="{{ route('login') }}" title="Wishlist">
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p>Login</p>
                    </a>
                </div>
            </div><!-- End .header-right -->
            @endif


        </div><!-- End .container -->
    </div><!-- End .header-middle -->


</header><!-- End .header -->
