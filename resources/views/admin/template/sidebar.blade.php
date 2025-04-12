<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
            data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
            data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
            data-kt-drawer-toggle="#kt_aside_mobile_toggle" style="background-color: var(--secondary-color);">



            <div class="aside-menu flex-column-fluid">
                <div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                    data-kt-scroll-height="auto" data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer',
            lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}" data-kt-scroll-wrappers="#kt_aside_menu"
                    data-kt-scroll-offset="5px">

                    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary
                menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu"
                        data-kt-menu="true">

                        <!-- Dashboard aktif saat awal -->

                        <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion ">
                            <a href="{{ url('/dashboard') }}" class="menu-link hover-secondary  text-hover-gray-300">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-element-11 text-white fs-2x">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title text-white text-hover-gray-300">Dashboards</span>
                            </a>
                        </div>










                        <div class="menu-item">
                            <a class="menu-link text-hover-gray-300" href="{{ route('produk.logproduk') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-scan-barcode text-white fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                    </i>

                                </span>
                                <span class="menu-title text-white text-hover-gray-300">Log Produk</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link text-hover-gray-300" href="{{ route('produk.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-handcart text-white fs-1">
                                    </i>
                                </span>
                                <span class="menu-title text-white text-hover-gray-300">Produk</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link text-hover-gray-300" href="{{ route('penjualan.index') }}">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-shop text-white fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>
                                </span>
                                <span class="menu-title text-white text-hover-gray-300">Penjualan</span>
                            </a>
                        </div>

                        @if (Auth::user()->role == "admin")
<div class="menu-item">
    <a class="menu-link text-hover-gray-300" href="{{ route('manage-user.index') }}">
        <span class="menu-icon">
            <i class="fas fa-th text-white fs-1"></i>
        </span>
        <span class="menu-title text-white text-hover-gray-300">Manage User</span>
    </a>
</div>
@endif

                        <div class="menu-item">
                            <a class="menu-link text-hover-gray-300" href="javascript:void(0);"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="menu-icon">
                                    <i class="ki-duotone ki-entrance-right text-white fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <span class="menu-title text-white text-hover-gray-300"
                                        style="margin-left: 10px">Logout</span>
                                </span>
                            </a>
                        </div>

                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const menuLinks = document.querySelectorAll('.menu-link');

                menuLinks.forEach(link => {
                    // Jika URL link sama dengan URL saat ini, tambahkan kelas 'active'
                    if (link.href === window.location.href) {
                        link.classList.add('active');
                    }

                    // Tambahkan event listener untuk menambahkan kelas aktif saat diklik
                    link.addEventListener('click', function () {
                        // Hapus kelas active dari semua link
                        menuLinks.forEach(el => el.classList.remove('active'));

                        // Tambahkan kelas active ke link yang diklik
                        this.classList.add('active');
                    });
                });
            });
        </script>