<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'category'
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //For Attendance
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('event_date', [$start, $end]);
    }
}
