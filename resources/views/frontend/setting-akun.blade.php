@extends('layouts.master-frontend')
@section('title', 'Setting Akun')
@section('content')
    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="home.html">Home</a></li>
                    <li class='active'>Setting Akun</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head" style="background-color: #5A98BF; border:white"><i
                                class="icon fa fa-align-justify fa-fw"></i> <span style="color: white">Data Akun</span>
                        </div>
                        <nav class="yamm megamenu-horizontal" role="navigation">
                            <ul class="nav">
                                <li class="menu-item">
                                    <a href="{{ route('setting-akun') }}">PROFILE</a>
                                </li>
                                <li class=" menu-item">
                                    <a href="{{ route('daftar-alamat') }}">DAFTAR ALAMAT</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <form method="POST" action="{{ route('update-user', $customer->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('bana') is-invalid @enderror" id="nama"
                                        name="nama" placeholder="Nama Lengkap"
                                        value="{{ old('nama') ? old('nama') : $customer->nama }}">
                                    @error('nama')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="telpon">No Telpon</label>
                                    <input type="text" class="form-control @error('telpon') is-invalid @enderror"
                                        id="telpon" name="telpon" placeholder="No Telpon"
                                        value="{{ old('telpon') ? old('telpon') : $customer->telpon }}">
                                    @error('telpon')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="
                                                                    exampleFormControlInput1" type="email"
                                        value="{{ old('email') ? old('email') : $customer->email }}" placeholder="Email"
                                        name="email" autocomplete="off">
                                    @error('email')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tangal Lahir</label>
                                    <input class="form-control @error('tanggal_lahir') is-invalid @enderror" id="
                                            tanggal_lahir" type="date"
                                        value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : $customer->tanggal_lahir }}"
                                        placeholder="Tanggal Lahir" name="tanggal_lahir" autocomplete="off">
                                    @error('tanggal_lahir')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki Laki" {{ old('jenis_kelamin') == 'Laki Laki' ? 'selected' : '' }} {{ $customer->jenis_kelamin == 'Laki Laki' ? 'selected' : '' }}>Laki Laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }} {{ $customer->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                        <span style="color: red">*kosongkan jika tidak ingin merubah password</span>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success"><i
                                        class="glyphicon glyphicon-floppy-save"></i> UPDATE</button>
                            </form>
                        </div>
                        <div class="clearfix">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
