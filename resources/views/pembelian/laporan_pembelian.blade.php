<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pembelian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h3>IP-KOMPUTER</h3>
        <span style="font-size: 11px">Jl. pandhawa gang nakula no.02 karangmloko, RT.01/RW.17, Tegal Weru, Sariharjo,
            Kec. Ngaglik, Kabupaten
            Sleman, Daerah Istimewa Yogyakarta 55581</span>

    </center>
    <hr>
    <center>
        <h4>Laporan Pembelian</h4>
    </center>


    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Kode Pembelian</th>
                <th>Supplier</th>
                <th>Tanggal</th>
                <th>Status Bayar</th>
                <th>Sub Total</th>
                <th>Diskon</th>
                <th>Grand Total</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->kode_pembelian }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->status_bayar }}</td>
                <td> @currency($row->grand_total)</td>
                <td> @currency($row->diskon)</td>
                <td> @currency($row->total)</td>

            </tr>
            @endforeach
            <tr>
                <td colspan="6"> <b style="float: right">Total Pembelian</b> </td>
                <td>@currency($totalPembelian)</td>

            </tr>
        </tbody>
    </table>
    <span style="font-size: 10px; float: right;margin-right:10px">Sleman, {{ date('d-m-Y') }}</span>
    <br>
    <br>
    <br>
    <br>

    <span style="font-size: 10px;float: right;margin-right:10px">{{ Auth::user()->name }}</span>




</html>
