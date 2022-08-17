<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white collapse" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('admin.index')}}">
                            <i class="ni ni-sound-wave text-primary"></i>
                            <span class="nav-link-text">Tổng quan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bm.index')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">BM</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bm.ad_account')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">BM Ad Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('bm.camp')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">BM Camp</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('act.index')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Cá nhân</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('act.ad_account')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Cá nhân Ad Account</span>
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
            </div>
        </div>
    </div>
</nav>
