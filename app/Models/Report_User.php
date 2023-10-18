<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Report_User extends Pivot
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    protected $table = 'report_user';

    public function report(){
        return $this->belongsTo(Report::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
