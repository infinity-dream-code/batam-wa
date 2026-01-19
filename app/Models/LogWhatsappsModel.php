<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogWhatsappsModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'log_whatsapps';

    protected $fillable = [
        'status',
        'custid',
        'no_wa',
        'pesan',
        'response',
        'nama',
        'log_id',
        'user_id',
    ];
}
