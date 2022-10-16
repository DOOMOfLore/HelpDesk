<?php

namespace App\Models\MainMenu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MainMenu extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'main_menu_id';
    // public $timestamps = false;
    protected $table = 'main_menu';
    protected static $logFillable = true;
    protected $fillable = [
        'main_menu',
        'description',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
