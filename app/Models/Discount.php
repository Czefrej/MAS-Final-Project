<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discount';
    protected $primaryKey = 'id';

    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
