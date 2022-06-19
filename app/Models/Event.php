<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'slots',
        'author_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function subcriptions()
    {
        return $this->hasMany(Subcription::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'subcriptions', 'event_id', 'user_id');
    }

    public function registerEvent($user_id)
    {
        $this->participants()->attach($user_id);
    }

    public function unregisterEvent($user_id)
    {
        $this->participants()->detach($user_id);
    }
}
