<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSapa extends Model
{
    
    protected $connection = 'sqlsrv';
    protected $table = 'Users';
    
    protected $fillable = [
        'UserId', 'Username', 'DisplayName', 'Email'
    ];

    public $timestamps = false; 
}
