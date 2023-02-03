<div class='col-md-3 sidebar'>
    <div class="side-menu animate-dropdown outer-bottom-xs">
        <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
        <nav class="yamm megamenu-horizontal" role="navigation">
            <ul class="nav">
                @foreach ($kategori as $data)
                    <li class="">
                        <a href="{{ route('kategori-produk',['id' => $data->id,'name' =>$data->nama_kategori ]) }}">{{ $data->nama_kategori }}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
