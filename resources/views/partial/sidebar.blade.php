<nav class="pcoded-navbar menupos-fixed menu-light brand-blue ">
    <div class="navbar-wrapper ">
        <div class="navbar-brand header-logo">
            <a href="index.html" class="b-brand">
                <!-- <img src="logo.svg" alt="" class="logo images">
                <img src="logo-icon.svg" alt="" class="logo-thumb images"> -->
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
        </div>
        <div class="navbar-content scroll-div">
            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item">
                    <a href="{{ URL::to('/orders') }}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-tasks"></i></span><span class="pcoded-mtext">Sân cầu lông</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('/product') }}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-wine-bottle"></i></i></span><span class="pcoded-mtext">Sản phẩm</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ URL::to('/manager') }}" class="nav-link"><span class="pcoded-micon"><i class="fas fa-cogs"></i></span><span class="pcoded-mtext">Quản lí & Cài đặt</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>