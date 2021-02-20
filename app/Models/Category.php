<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function parent(){
        return $this->hasOne(Category::class,'id',"parent_id");
    }

    public function children(){
        return $this->hasMany(Category::class);
    }

    public function offers(){
        return $this->hasMany('App\Models\Offer');
    }

    public function discounts(){
        return $this->hasMany(Discount::class);
    }

}
