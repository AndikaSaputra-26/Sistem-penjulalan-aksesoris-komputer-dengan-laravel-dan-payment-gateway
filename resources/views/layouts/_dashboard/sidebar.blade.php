<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-desktop"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ set_active('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
    </li>

    @canany(['unit_show', 'produk_show', 'kategori_show'])
        <li class="nav-item {{ set_active(['unit*', 'kategori*', 'produk*']) }}">
            <a class="nav-link {{ request()->routeIs('unit*', 'kategori*', 'produk*') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseMasterProduk" aria-expanded="true"
                aria-controls="collapseMasterProduk">
                <i class="fas fa-fw fa-cube"></i>
                <span>Data Produk</span>
            </a>
            <div id="collapseMasterProduk"
                class="collapse {{ request()->routeIs('unit*', 'kategori*', 'produk*') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('produk_show')
                        <a class="collapse-item {{ set_active(['produk*']) }}" href="{{ route('produk.index') }}">
                            Produk</a>
                    @endcan
                    @can('kategori_show')
                        <a class="collapse-item {{ set_active(['kategori*']) }}" href="{{ route('kategori.index') }}">
                            Kategori Produk</a>
                    @endcan
                    @can('unit_show')
                        <a class="collapse-item {{ set_active(['unit*']) }}" href="{{ route('unit.index') }}"> Unit</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcanany

    @canany(['customer_show', 'supplier_show'])
        <li class="nav-item {{ set_active(['customer*', 'supplier*']) }}">
            <a class="nav-link {{ request()->routeIs('customer*', 'supplier*') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseMasterKontak" aria-expanded="true"
                aria-controls="collapseMasterKontak">
                <i class="fas fa-address-card"></i>
                <span>Kontak</span>
            </a>
            <div id="collapseMasterKontak"
                class="collapse {{ request()->routeIs('customer*', 'supplier*') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('customer_show')
                        <a class="collapse-item {{ set_active(['customer*']) }}" href="{{ route('customer.index') }}">
                            Customer</a>
                    @endcan
                    @can('supplier_show')
                        <a class="collapse-item {{ set_active(['supplier*']) }}" href="{{ route('supplier.index') }}">
                            Supplier</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcanany

    @canany(['pembelian_show'])
        <li class="nav-item {{ set_active('pembelian*') }}">
            <a class="nav-link" href="{{ route('pembelian.index') }}">
                <i class="fas fa-fw fa-money-bill"></i>
                <span>Pembelian</span></a>
        </li>
    @endcanany

    @canany(['transaksi_show'])
        <li class="nav-item {{ set_active('transaksi*') }}">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Penjualan</span></a>
        </li>
    @endcanany
    @canany(['pesan_show'])
        <li class="nav-item {{ set_active('pesan*') }}">
            <a class="nav-link" href="{{ route('pesan.index') }}">
                <i class="fas fa-fw fa-envelope"></i>
                <span>Pesan</span>
                @php
                    $jml = DB::table('pesan')
                        ->where('is_read', '=', 0)
                        ->count();
                @endphp
                @if ($jml > 0)
                    <span class="badge bg-danger-soft text-danger ms-auto">1 New</span>
                @endif
            </a>

        </li>
    @endcanany

    @canany(['user_show', 'role_show', 'toko_show'])
        <li class="nav-item {{ set_active(['roles*', 'user*', 'setting-toko*']) }}">
            <a class="nav-link {{ request()->routeIs('roles*', 'user*', 'setting-toko*') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapsePages3" aria-expanded="true" aria-controls="collapsePages3">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Setting</span>
            </a>
            <div id="collapsePages3"
                class="collapse {{ request()->routeIs('roles*', 'user*', 'setting-toko*') ? 'show' : '' }}"
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('user_show')
                        <a class="collapse-item {{ set_active(['user*']) }}" href="{{ route('user.index') }}"> User</a>
                    @endcan
                    @can('role_show')
                        <a class="collapse-item {{ set_active(['roles*']) }}" href="{{ route('roles.index') }}"> Roles</a>
                    @endcan
                    @can('toko_show')
                        <a class="collapse-item {{ set_active(['setting-toko*']) }}"
                            href="{{ route('setting-toko.index') }}"> Setting Toko</a>
                    @endcan
                    @can('belanja_show')
                        <a class="collapse-item {{ set_active(['cara-belanja*']) }}"
                            href="{{ route('cara-belanja.index') }}"> Cara Belanja</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcanany
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
