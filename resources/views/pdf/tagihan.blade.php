@php use Carbon\Carbon; @endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tagihan {{$siswa->nis??''}} - {{$siswa->nama??''}}</title>

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
            text-align: left;
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
        <td colspan="2">Tagihan
            @isset($tagihans)
                &nbsp;Cicilan
            @endisset
        </td>
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
        <td>:<strong> {{$siswa->kelas??''}} {{$siswa->kelompok??''}}</strong></td>
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
        <th>Nama Post</th>
        <th>Nama Tagihan</th>
        <th>Tagihan</th>
        <th>Dibayar</th>
        <th>Tanggal Bayar</th>
        <th>Status Bayar</th>
    </tr>
    </thead>
    @isset($tagihan)
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>{{$tagihan->KodePost}}</td>
            <td>{{$tagihan->BILLNM}}</td>
            <td align="right">@rupiah($tagihan->BILLAM)</td>
            <td align="right">@rupiah($tagihan->PAIDAM)</td>
            <td align="center">{{$tagihan->PAIDDT?Carbon::parse($tagihan->PAIDDT)->isoFormat('dddd, D MMMM YYYY'):'-'}}</td>
            <td align="center">{{$tagihan->PAIDST == 1 ?'DIBAYAR': 'BELUM DIBAYAR'}}</td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"></td>
            <td align="right">Total Tagihan</td>
            <td align="right">@rupiah($tagihan->BILLAM)</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right">Total Pembayaran</td>
            <td align="right">@rupiah($tagihan->PAIDAM)</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right">Sisa Tagihan</td>
            <td align="right" class="gray">@rupiah($tagihan->BILLAM - $tagihan->PAIDAM)</td>
        </tr>
        </tfoot>
    @elseif($tagihans)
        <tbody>
        @foreach($tagihans as $tagihan)
            <tr>
                <th scope="row">{{$loop->index + 1}}</th>
                <td>{{$tagihan->KodePost}}</td>
                <td>{{$tagihan->BILLNM}}</td>
                <td align="right">@rupiah($tagihan->BILLAM)</td>
                <td align="right">@rupiah($tagihan->PAIDAM)</td>
                <td align="center">{{$tagihan->PAIDDT?Carbon::parse($tagihan->PAIDDT)->isoFormat('dddd, D MMMM YYYY'):'-'}}</td>
                <td align="center">{{$tagihan->PAIDST == 1 ?'DIBAYAR': 'BELUM DIBAYAR'}}</td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"></td>
            <td align="right">Total Tagihan</td>
            <td align="right">@rupiah($tagihans->sum('BILLAM'))</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right">Total Pembayaran</td>
            <td align="right">@rupiah($tagihans->sum('PAIDAM'))</td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right">Sisa Tagihan</td>
            <td align="right"
                style="background-color: #ededed">@rupiah($tagihans->sum('BILLAM') - $tagihans->sum('PAIDAM'))</td>
        </tr>
        </tfoot>
    @endisset
</table>
<br>
<br>
<table style="width: 100%">
    <tfoot>
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
