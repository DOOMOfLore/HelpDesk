<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Complaint extends Model
{
    use HasFactory, LogsActivity;
    public $primaryKey = 'complaint_id';
    // public $timestamps = false;
    protected $table = 'complaint';
    protected static $logFillable = true;
    protected $fillable = [
        'complaint_name',
        'code_request',
        'mps_user',
        'main_menu',
        'categories',
        'other_categories',
        'description',
        'request',
        'reason',
        'picture',
        'complaint_source_division',
        'complaint_classification',
        'complaint_sub_classification',
        'complaint_pic',
        'complaint_treatment',
        'complaint_user_input',
        'complaint_status',
        'complaint_status_code',
        'is_active',
        'treatment',
        'created_at',
        'updated_at',
    ];

    public static function release()
    {
        $data = Complaint::select('*')->where('complaint_status_code', 'LIKE', '%release%')->where('is_active', '1')->get();
        return $data;
    }

    public static function waitingapproval()
    {
        $data = Complaint::select('*')->where('complaint_status_code', 'LIKE', '%Waiting for Approval%')->where('is_active', '1')->get();
        return $data;
    }

    public static function onprocess()
    {
        $data = Complaint::select('*')->where('complaint_status_code', 'LIKE', '%On Proses%')->where('is_active', '1')->get();
        return $data;
    }

    public static function unapproved()
    {
        $data = Complaint::select('*')->where('complaint_status_code', 'LIKE', '%Unapproved%')->where('is_active', '1')->get();
        return $data;
    }

    public static function solved()
    {
        $data = Complaint::select('*')->where('complaint_status_code','LIKE','%Solved%')->where('is_active','1')->get();
        return $data;
    }
}
