<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = ['nik', 'pt_id', 'user_id'];

    public function pt()
    {
        return $this->belongsTo(PT::class, 'pt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
