<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    use HasFactory;

    protected $table = 'group_user';

    protected $fillable = ['group_id', 'user_id', 'dep_id'];

    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Devision::class, 'dep_id');
    }
}
