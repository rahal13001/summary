<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Indicator extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'update_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }


   public function reports(){
       return $this->belongsToMany(Report::class);
   }
}
