<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
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
                        <a class="nav-link" href="{{route('report.index')}}">
                            <i class="ni ni-cart text-orange"></i>
                            <span class="nav-link-text">Báo cáo</span>
                        </a>
                    </li>
                    <li class="nav-item" v-if="global.loggedUser.role == 'admin'">
                        <a class="nav-link" href="{{route('product.index')}}">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Sản phẩm</span>
                        </a>
                    </li>
                </ul>
                <!-- Divider -->
                <hr class="my-3">
            </div>
        </div>
    </div>
</nav>
