<?php

namespace App\Models\UserInput;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserInput extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'user_input_id';
    // public $timestamps = false;
    protected $table = 'user_input';
    protected static $logFillable = true;
    protected $fillable = [
        'user_input',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
