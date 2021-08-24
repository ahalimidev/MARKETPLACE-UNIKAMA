
    <div class="mobile-menu-container mobile-menu-light">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form class="mobile-search">
                <label for="keyword" class="sr-only">Search</label>
                <input type="search" class="form-control" name="keyword" id="keyword"
                    placeholder="Search in..." required>
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>

            <ul class="nav nav-pills-mobile nav-border-anim" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab"
                        role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu</a>
                </li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel"
                    aria-labelledby="mobile-menu-link">
                    <nav class="mobile-cats-nav">
                        <ul class="mobile-cats-menu">
                            @foreach ($menu_kategori as $item )
                            <li><a href="{{ route('kategori',['nama'=>$item->nama_kategori,'id'=>$item->id_kategori]) }}">{{$item->nama_kategori}}</a></li>

                            @endforeach

                        </ul><!-- End .mobile-cats-menu -->
                    </nav><!-- End .mobile-cats-nav -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
