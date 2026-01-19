<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScctBillDetailModel extends Model
{
    protected $table = 'scctbill_detail';
    protected $connection = 'mysql2';

    protected $fillable = [
        'KodePost',
        'BILLAM',
        'CUSTID',
        'FID',
        'tahun',
        'periode',
        'BILLCD',
    ];

    //CUSTID : id siswa
    //METODE : jenis inputan TOP UP atau debet pembayaran tagihan FROM INVOICE
    //TRXDATE : tanggal transaksinya
    //NOREFF : nomor referensi transaksi dari bank
    //FIDBANK : kadang kalau kredit isinya kosong atau kalau pembayaran di isi dengan id user login teller yang mentransaksikan pembayaran
    //KDCHANNEL : berisi nomor penanda asal transaksi dari mana,, misal 1 berarti dari Mbanking, misal 2 berarti dari ATM dll
    //DEBET : dana keluar
    //KREDIT : dana masuk
    //REFFBANK : biasanya untuk nomor penanda transaksi (diambilkan dari kode bcn digit ke 5 dan 6)
    //TRANSNO : berisi keterangan atau nomor transaksi dari bank selain noreff
}
