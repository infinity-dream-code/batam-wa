@php
    use Carbon\Carbon;$data = [
        ['student' => 'Student 1', 'subject' => 'math', 'grade' => 80],
        ['student' => 'Student 3', 'subject' => 'biology', 'grade' => 80],
        ['student' => 'Student 2', 'subject' => 'computer', 'grade' => 90],
        ['student' => 'Student 2', 'subject' => 'math', 'grade' => 70],
        ['student' => 'Student 2', 'subject' => 'biology', 'grade' => 80],
    ];
@endphp
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>

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
@php
    print_r($filter);
@endphp
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
        <td colspan="2" align="center"><h2>REKAP PEMBAYARAN</h2></td>
    </tr>
    <tr>
        <td colspan="2" align="center">@php echo $filter['tanggal-transaksi']; @endphp</td>
    </tr>
</table>

<br/>

<table width="100%" class="table-border">
    <thead class="table-border" style="background-color: #ededed;">
    <tr>
        <th>#</th>
        <th>Nama Tagihan</th>
        <th>Tagihan</th>
        <th>Dibayar</th>
    </tr>
    </thead>
    <tbody>
    @php $currentStudent = null; @endphp
    @foreach($data as $entry)
        <tr>
            @if($currentStudent !== $entry['student'])
                @php $currentStudent = $entry['student']; @endphp
                <td>{{ $entry['student'] }}</td>
            @else
                <td></td>
            @endif
            <td>{{ $entry['subject'] }}</td>
            <td>{{ $entry['grade'] }}</td>
        </tr>
    @endforeach
    </tbody>
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
