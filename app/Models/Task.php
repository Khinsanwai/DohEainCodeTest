<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Project;

class Task extends Model  
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'project_id',          
        'assigned_user_id',    
        'status',              
        'due_date'             
    ];
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}
