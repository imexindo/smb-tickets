<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = ['user_id', 'no', 'date', 'category_id', 'desc'];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'ticket_id');
    }

    public function latestHistory()
    {
        return $this->hasOne(History::class, 'ticket_id')
            ->latestOfMany()
            ->select('history.id', 'history.ticket_id', 'history.date', 'history.status_id', 'history.remark', 'history.user_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'ticket_id');
    }
}
