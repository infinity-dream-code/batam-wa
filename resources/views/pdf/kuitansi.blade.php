@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran {{$siswa->nis??''}} - {{$siswa->nama??''}}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }

        .table-border {
            border-collapse: collapse;
        }

        .table-border td, th {
            border: 2px solid lightgray;
            padding: 8px;
        }

        .border-bottom {
            border-collapse: collapse;
            border-bottom: 2px solid #000;
            text-align: left;
            padding: 8px;
        }

        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<table width="100%" class="border-bottom">
    <tr class="border-bottom">
        <td valign="top"><img src="{{public_path('Logo 512_2.png')}}" style="max-height: 125px;"/></td>
        <td>
            <table>
                <tr>
                    <td align="center">
                        <h1>{{config('app.nama_instansi')}}</h1>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        {{config('app.alamat')}}
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        {{config('app.email')}}
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        {{config('app.telepon')}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br>
<table width="100%">
    <tr>
        <td colspan="2" align="center"><h2>BUKTI PEMBAYARAN</h2></td>
    </tr>
    <tr>
        <td colspan="2" style="color: #fff">-</td>
    </tr>
    <tr>
        <td style="width: 20% ;">Nama Siswa</td>
        <td>:<strong> {{$siswa->nama??''}} </strong></td>
    </tr>
    <tr>
        <td>NIS</td>
        <td>:<strong> {{$siswa->nis??''}}</strong></td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>:<strong> {{$siswa->kelas??''}}</strong></td>
    </tr>
    <tr>
        <td>Angkatan:</td>
        <td>:<strong> {{$siswa->thn_aka??''}}</strong></td>
    </tr>
</table>

<br/>

<table width="100%" class="table-border">
    <thead class="table-border" style="background-color: #ededed;">
    <tr>
        <th>#</th>
        <th>Nama Tagihan</th>
        <th>Total Tagihan</th>
        <th>Total Bayar</th>
        <th>Dibayar</th>
        <th>Sisa Tagihan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tagihans as $tagihan)
        <tr>
            <th scope="row">{{$loop->index + 1}}</th>
            <td>{{$tagihan->BILLNM}}</td>
            <td align="right">@rupiah($tagihan->BILL_TOTAL)</td>
            <td align="right">@rupiah($tagihan->BILL_TOTAL - ($tagihan->sisa_tagihan??0))</td>
            <td align="right">@rupiah($tagihan->PAIDAM)</td>
            <td align="right">@rupiah($tagihan->sisa_tagihan??0)</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td align="right" colspan="4">Total</td>
        <td align="right" style="background-color: #ededed;">@rupiah($tagihans->sum('PAIDAM'))</td>
        <td align="right" style="background-color: #ededed;">@rupiah($tagihans->sum('sisa_tagihan'))</td>
    </tr>
    </tfoot>
</table>
<br>
<br>
<table style="width: 100%">
    <tfoot>
    <tr>
        <td colspan="5">*Bukti pembayaran ini harap disimpan</td>
        <td style="color: #fff;">-</td>
        <td align="right"></td>
    </tr>
    <tr>
        <td colspan="5" style="color: #fff;">TESTING</td>
        <td style="color: #fff;">TESTING</td>
        <td align="right">{{config('app.domisili')}}</td>
    </tr>
    <tr>
        <td colspan="5" style="color: #fff;">TESTING</td>
        <td style="color: #fff;">TESTING</td>
        <td align="right">{{Carbon::now()->isoFormat('dddd, D MMMM YYYY')}}</td>
    </tr>
    <tr>
        <td colspan="5" style="color: #fff;">TESTING</td>
        <td style="color: #fff;">TESTING</td>
        <td align="right"></td>
    </tr>
    <tr>
        <td colspan="5" style="color: #fff;">TESTING</td>
        <td style="color: #fff;">KOSONG</td>
        <td align="right"></td>
    </tr>
    TESTING
    <tr>
        <td colspan="5" style="color: #fff;">TESTING</td>
        <td style="color: #fff;">KOSONG</td>
        <td align="right">Bagian Keuangan</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
