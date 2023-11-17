<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs'; // Specify the table name
    protected $fillable = [
        'is_done',
        'execute_at'
    ];
}
