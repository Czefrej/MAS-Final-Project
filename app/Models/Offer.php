<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'stock',
        'creator_id',
        'category_id'
    ];

    protected $table = 'offer';
    protected $primaryKey = 'id';


    public function offerable(){
        return $this->morphTo();
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function discounts(){
        return $this->hasMany(Discount::class);
    }

    public function creator(){
        return $this->belongsTo(User::class);
    }

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
}
