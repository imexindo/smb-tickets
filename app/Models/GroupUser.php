<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    protected $table = 'group_user';

    protected $fillable = ['group_id', 'user_id', 'division_id'];

    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function division()
    {
        return $this->belongsTo(Devision::class, 'division_id');
    }
}
