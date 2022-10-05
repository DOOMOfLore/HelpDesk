<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersLog extends Model
{
    use HasFactory;
    public $primaryKey = 'id';
    public $timestamps = false;
    protected $table = 'users_logs';
    protected $fillable = [
        'id',
        'username',
        'login_date',
        'login_ip',
        'login_browser',
        'result_login',
        'created_at',
        'updated_at',
    ];
}
