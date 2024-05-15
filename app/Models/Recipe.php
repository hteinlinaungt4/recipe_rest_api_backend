<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory;

    public function category(){

        return $this->belongsTo(Category::class);
    }


    public function scopeFilter($query,$filters){
        if(isset($filters['category'])){
            $query->whereHas('category',function($catquery) use ($filters){
                $catquery->where('name',$filters['category']);
            });
        }
    }
}
