<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $fillable = ['ticket_id', 'request_id', 'approve_id', 'path'];
}
