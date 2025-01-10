<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model; 
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Project  extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'manager_id',
        'status'
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

}