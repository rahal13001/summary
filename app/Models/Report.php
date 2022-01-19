<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Report extends Model
{
    use HasFactory;
    use Sluggable;

    protected $guarded = ['id'];

     public function getRouteKeyName()
    {
        return 'slug';
    }
    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documentation(){
        return $this->hasOne(Documentation::class);
    }

     public function follower(){
        return $this->belongsToMany(User::class,'followers', 'report_id', 'user_id');
    }

    public function indicators(){
        return $this->belongsToMany(Indicator::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'what'
            ]
        ];
    }


}
