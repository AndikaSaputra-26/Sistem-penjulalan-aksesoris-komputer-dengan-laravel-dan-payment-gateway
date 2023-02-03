<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// ============================================================================================================
//Produk
Breadcrumbs::for('produk_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Produk', route('produk.index'));
});
//Produk > Tambah
Breadcrumbs::for('produk-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('produk_index');
    $trail->push('Tambah Produk', route('produk.create'));
});
//Produk > Edit
Breadcrumbs::for('produk-edit', function (BreadcrumbTrail $trail, $produk) {
    $trail->parent('produk_index');
    $trail->push('Edit', route('produk.edit', $produk));
    $trail->push($produk->kode_produk. ' - ' .$produk->nama , route('produk.edit', $produk));
});


// ============================================================================================================
//unit
Breadcrumbs::for('unit_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Unit', route('unit.index'));
});
//unit > Tambah
Breadcrumbs::for('unit-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('unit_index');
    $trail->push('Tambah Unit', route('unit.create'));
});
//Unit > Edit
Breadcrumbs::for('unit-edit', function (BreadcrumbTrail $trail, $unit) {
    $trail->parent('unit_index');
    $trail->push('Edit', route('unit.edit', $unit));
    $trail->push($unit->nama_unit, route('unit.edit', $unit));
});

// ============================================================================================================
//Pembalian
Breadcrumbs::for('pembelian_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Pembelian', route('pembelian.index'));
});
//Pembalian > Tambah
Breadcrumbs::for('pembelian-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('pembelian_index');
    $trail->push('Tambah Pembelian', route('pembelian.create'));
});
//Pembalian > Edit
Breadcrumbs::for('pembelian-edit', function (BreadcrumbTrail $trail, $pembelian) {
    $trail->parent('pembelian_index');
    $trail->push('Edit', route('pembelian.edit', $pembelian));
    $trail->push($pembelian->kode_pembelian, route('pembelian.edit', $pembelian));
});



// ============================================================================================================
//transaksi
Breadcrumbs::for('transaksi_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data transaksi', route('transaksi.index'));
});
//transaksi > Tambah
Breadcrumbs::for('transaksi-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('transaksi_index');
    $trail->push('Tambah transaksi', route('transaksi.create'));
});
//transaksi > Edit
Breadcrumbs::for('transaksi-edit', function (BreadcrumbTrail $trail, $transaksi) {
    $trail->parent('transaksi_index');
    $trail->push('Edit', route('transaksi.edit', $transaksi));
    $trail->push($transaksi->kode_transaksi, route('transaksi.edit', $transaksi));
});

// ============================================================================================================
//kategori
Breadcrumbs::for('kategori_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kategori', route('kategori.index'));
});
//kategori > Tambah
Breadcrumbs::for('kategori-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('kategori_index');
    $trail->push('Tambah Kategori', route('kategori.create'));
});
//kategori > Edit
Breadcrumbs::for('kategori-edit', function (BreadcrumbTrail $trail, $kategori) {
    $trail->parent('kategori_index');
    $trail->push('Edit', route('kategori.edit', $kategori));
    $trail->push($kategori->nama_kategori, route('kategori.edit', $kategori));
});


// ============================================================================================================
//supplier
Breadcrumbs::for('supplier_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data supplier', route('supplier.index'));
});
//supplier > Tambah
Breadcrumbs::for('supplier-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier_index');
    $trail->push('Tambah supplier', route('supplier.create'));
});
//supplier > Edit
Breadcrumbs::for('supplier-edit', function (BreadcrumbTrail $trail, $supplier) {
    $trail->parent('supplier_index');
    $trail->push('Edit', route('supplier.edit', $supplier));
    $trail->push($supplier->kode_supplier. ' - ' .$supplier->nama_supplier , route('supplier.edit', $supplier));
});

// ============================================================================================================
//pesan
Breadcrumbs::for('pesan_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data pesan', route('pesan.index'));
});
//pesan > Tambah
Breadcrumbs::for('pesan-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('pesan_index');
    $trail->push('Tambah pesan', route('pesan.create'));
});
//pesan > Edit
Breadcrumbs::for('pesan-edit', function (BreadcrumbTrail $trail, $pesan) {
    $trail->parent('pesan_index');
    $trail->push('Edit', route('pesan.edit', $pesan));
    $trail->push($pesan->nama , route('pesan.edit', $pesan));
});



// ============================================================================================================
//cara_belanja
Breadcrumbs::for('belanja_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Cara Belanja', route('cara-belanja.index'));
});
//cara_belanja > Tambah
Breadcrumbs::for('belanja-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('belanja_index');
    $trail->push('Tambah Cara Belanja', route('cara-belanja.create'));
});
//cara_belanja > Edit
Breadcrumbs::for('belanja-edit', function (BreadcrumbTrail $trail, $caraBelanja) {
    $trail->parent('belanja_index');
    $trail->push('Edit', route('cara-belanja.edit', $caraBelanja));
    $trail->push($caraBelanja->title , route('cara-belanja.edit', $caraBelanja));
});



// ============================================================================================================
//customer
Breadcrumbs::for('customer_index', function (BreadcrumbTrail $trail) {
    $trail->push('Data customer', route('customer.index'));
});
//customer > Tambah
Breadcrumbs::for('customer-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('customer_index');
    $trail->push('Tambah customer', route('customer.create'));
});
//customer > Edit
Breadcrumbs::for('customer-edit', function (BreadcrumbTrail $trail, $customer) {
    $trail->parent('customer_index');
    $trail->push('Edit', route('customer.edit', $customer));
    $trail->push($customer->nama , route('customer.edit', $customer));
});



// ============================================================================================================
//setting-toko
Breadcrumbs::for('toko_index', function (BreadcrumbTrail $trail) {
    $trail->push('Setting Toko', route('setting-toko.index'));
});


// ============================================================================================================
// Roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->push('Roles', route('roles.index'));
});
// Roles > Tambah
Breadcrumbs::for('roles-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Tambah Role', route('roles.create'));
});
//Roles > Detail
Breadcrumbs::for('roles-show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles');
    $trail->push('Detail', route('roles.show', $role));
    $trail->push($role->name , route('roles.show', $role));
});
//Roles > Edit
Breadcrumbs::for('roles-edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('roles');
    $trail->push('Edit', route('roles.edit', $role));
    $trail->push($role->name, route('roles.edit', $role));
});
// ============================================================================================================
// User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('User', route('user.index'));
});

// User > Tambah
Breadcrumbs::for('user-tambah', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Tambah User', route('user.create'));
});

//User > Edit
Breadcrumbs::for('user-edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user');
    $trail->push('Edit', route('user.edit', $user));
    $trail->push($user->name, route('user.edit', $user));
});
// ============================================================================================================
Breadcrumbs::for('laporan-pembelian', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan Pembelian', route('laporan-pembelian'));
});

Breadcrumbs::for('laporan-transaksi', function (BreadcrumbTrail $trail) {
    $trail->push('Laporan transaksi', route('laporan-transaksi'));
});

