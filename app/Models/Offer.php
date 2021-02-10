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

    protected $table = 'offers';
    protected $primaryKey = 'id';

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
