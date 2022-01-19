<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
  use \Znck\Eloquent\Traits\BelongsToThrough;
    use HasFactory;

    protected $guarded=['id'];

        
    public function report(){
      return  $this->belongsTo(Report::class);
    }

    public function userfoll(){
       return $this->belongsTo(User::class,'user_id');
    }


    public function penyusun(){
      return $this->belongsToThrough(User::class, Report::class);
    }
}
