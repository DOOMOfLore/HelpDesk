<?php

namespace App\Models\PIC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PIC extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'pic_id';
    // public $timestamps = false;
    protected $table = 'pic';
    protected static $logFillable = true;
    protected $fillable = [
        'pic',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
