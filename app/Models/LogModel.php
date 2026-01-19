<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogModel extends Model
{
    protected $table = 'log';
    protected $connection = 'mysql';

    protected $fillable = [
        'user_id',
        'menu',
        'aksi',
        'target_id',
        'ip_address',
        'client_info',
        'status',
    ];
}
