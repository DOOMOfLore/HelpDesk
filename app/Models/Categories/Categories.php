<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Categories extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'categories_id';
    // public $timestamps = false;
    protected $table = 'categories';
    protected static $logFillable = true;
    protected $fillable = [
        'categories',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
