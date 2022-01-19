<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Tag extends Model
{

   use \Znck\Eloquent\Traits\BelongsToThrough;
    use HasFactory;

    protected $table = 'indicator_report';

    public function indicator(){
       return $this->belongsTo(Indicator::class, 'indicator_id');
    }

    public function report(){
       return $this->belongsTo(Report::class, 'report_id');
    }

    public function penyusun(){
      return $this->belongsToThrough(User::class, Report::class);
    }


}
