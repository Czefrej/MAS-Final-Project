<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = "transaction";
    protected $fillable = ["user_id"];



    public function offer(){
        return $this->belongsTo(Offer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
