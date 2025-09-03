<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'm_status';

    protected $fillable = ['name', 'name_by_req', 'name_by_recv','next_action', 'bg_color'];
}
