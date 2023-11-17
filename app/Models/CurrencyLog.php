<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyLog extends Model
{
    protected $table = 'currency_log'; // Specify the table name
    protected $fillable = [
        'file_path',
    ];
}
