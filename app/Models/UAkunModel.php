<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UAkunModel extends Model
{
    protected $table = 'u_akun';
    protected $connection = 'mysql2';

    protected $fillable = [
        'KodeAKun',
        'NamaAKun',
        'NoRek',
    ];

    //scctbill.BILLCD --> kode tagihan per id anak
    //scctbill.BILLAC --> jika tagihan dari PSB di kolom ini baru terisi biasanya isinya A1 keterangan dari PSB nya oppa ,, kalau enggak ya kosong / null
    //scctbill.BILLNM --> nama tagihan
    //scctbill.BILLAM --> nominal tagihan
    //scctbill.FLPART --> biasanya untuk penanda cicilan berapa kali 1, 2, 3, dan seterusnya
    //scctbill.PAIDST --> status pembayaran kalau 1 artinya lunas kalau 0 artinya belum lunas
    //scctbill.PAIDDT --> tanggal pembayaran tagihan
    //scctbill.NOREFF --> nomor referensi transaksi VA
    //scctbill.FSTSBolehBayar --> keterangan tagihan aktif, kalau 1 artinya tagihan aktif kalau 0 artinya tagihan non aktif / hidden (tidak bisa dilihat oleh admin atau ortu siswa)
    //scctbill.FUrutan --> urutan prioritas pembayaran, biasanya urutan sesuai dengan urutan pembuatan tagihan
    //scctbill.FTGLTagihan --> tanggal tagihan dibuat
    //scctbill.FIDBANK --> kode channel pembayaran, jika dari online atm, mobile, ibanking, atau lainnya isinya biasanya angka 1, 2, 4, dan seterusnya jika dari pembayaran manual biasanya isinya 114000 manual cash, 1140001 manual bmi, 1140002 manual saldo dan seterusnya
    //scctbill.FRecID --> keterangan teller manual, jika pembayaran manual maka akan terisi user login teller, kalau pembayaran VA maka kolom ini kosong tp tidak null
    //scctbill.AA --> urutan dari semua create tagihan
    //scctbill.BTA --> tahun akademik tagihan
    //scctbill.TRANSNO --> biasanya untuk nomor transaksi manual
    //scctbill.CreateID --> keterangan tagihan dibuat oleh siapa, terisi sesuai user login admin yang input data tagihan
    //scctbill.PAIDDT_ACTUAL --> tanggal bayar sebenarnya, jika admin memilih tanggal bayar yang bukan tanggal hari itu pada saat eksekusi
}
