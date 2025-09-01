<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PT extends Model
{
    use HasFactory;

    protected $table = 'm_pt';

    protected $fillable = ['name', 'address'];
}
