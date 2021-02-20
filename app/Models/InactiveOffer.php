<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InactiveOffer extends Model
{
    use HasFactory;
    protected $table = "inactive_offer";
    public function offer()
    {
        return $this->morphOne(Offer::class, 'offerable');
    }

    public function activate(){
        $offer = $this->offer()->first();
        $active_offer = ActiveOffer::create();
        $active_offer->offer()->save($offer);
        $this->delete();

        return $active_offer;
    }

    public function sold(){
        $offer = $this->offer()->first();
        $sold_offer = SoldOffer::create();
        $sold_offer->offer()->save($offer);
        $this->delete();

        return $sold_offer;
    }

    public function comingsoon(){
        $offer = $this->offer()->first();
        $coming_soon_offer = ComingSoonOffer::create();
        $coming_soon_offer->offer()->save($offer);
        $this->delete();

        return $coming_soon_offer;
    }
}
