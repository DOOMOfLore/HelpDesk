<?php

namespace App\Models\Classification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Classification extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'classification_id';
    // public $timestamps = false;
    protected $table = 'classification';
    protected static $logFillable = true;
    protected $fillable = [
        'classification',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
