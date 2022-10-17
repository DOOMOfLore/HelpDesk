<?php

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Status extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'status_id';
    // public $timestamps = false;
    protected $table = 'status';
    protected static $logFillable = true;
    protected $fillable = [
        'status',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
