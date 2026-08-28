<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class RegisterInvite extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable; 
    
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
    
    protected $fillable = [
        'name',
        'email',
        'control_number',
        'company',
        'title',
        'notes',
        'attending',
        'confirm',
    ];
}
