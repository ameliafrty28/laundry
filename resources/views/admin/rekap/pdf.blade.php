<!DOCTYPE html>
<html>
<head>

    <title>Laporan Rekap Harian</title>

    <style>

        body{
            font-family: sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        table th,
        table td{

            border:1px solid black;

            padding:7px;

            text-align:center;
        }

        th{
            background:#f2f2f2;
        }

    </style>

</head>
<body>

<h2>
    LAPORAN REKAP HARIAN
</h2>

<br>

<table>

    <thead>

    <tr>

        <th>No</th>
        <th>Tanggal</th>
        <th>Total Transaksi</th>
        <th>Pendapatan</th>
        <th>Reg Kilo</th>
        <th>Exp Kilo</th>
        <th>Reg Sat</th>
        <th>Exp Sat</th>

    </tr>

    </thead>

    <tbody>

    @foreach($rekap as $i => $r)

    <tr>

        <td>
            {{ $i+1 }}
        </td>

        <td>
            {{ \Carbon\Carbon::parse($r->rekap_tanggal)->format('d-m-Y') }}
        </td>

        <td>
            {{ $r->rekap_total_transaksi }}
        </td>

        <td>

            Rp {{ number_format($r->rekap_total_pendapatan,0,',','.') }}

        </td>

        <td>
            {{ $r->rekap_reguler_kiloan }}
        </td>

        <td>
            {{ $r->rekap_ekspres_kiloan }}
        </td>

        <td>
            {{ $r->rekap_reguler_satuan }}
        </td>

        <td>
            {{ $r->rekap_ekspres_satuan }}
        </td>

    </tr>

    @endforeach

    </tbody>

</table>

<br>

<h4>

    Total Pendapatan :

    Rp {{ number_format($totalPendapatan,0,',','.') }}

</h4>

<h4>

    Total Transaksi :

    {{ $totalTransaksi }}

</h4>

</body>
</html>