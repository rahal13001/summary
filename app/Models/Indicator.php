<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicator extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $fillable = ['nama', 'nomor', 'tahun', 'status', 'slug'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama', 'tahun',
                'onUpdate' => true,
            ]
        ];
    }

    public function report(){
        return $this->belongsToMany(Report::class, 'indicator_report', 'indicator_id', 'report_id');
    }

    
    public function scopeCari($query, $term){
        $term = "%$term%";
        $query->where('nama','like', $term)
        ->orWhere('tahun', 'like', $term)
        ->orWhere('nomor', 'like', $term);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
