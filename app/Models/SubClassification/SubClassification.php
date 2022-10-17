<?php

namespace App\Models\SubClassification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SubClassification extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'sub_classification_id';
    // public $timestamps = false;
    protected $table = 'sub_classification';
    protected static $logFillable = true;
    protected $fillable = [
        'sub_classification',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
