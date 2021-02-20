<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveOffer extends Model
{
    use HasFactory;
    protected $table = "active_offer";
    public function offer()
    {
        return $this->morphOne(Offer::class, 'offerable');
    }

    public function deactivate(){
        $offer = $this->offer()->first();
        $inactive_offer = InactiveOffer::create();
        $inactive_offer->offer()->save($offer);
        $this->delete();

        return $inactive_offer;
    }

    public function comingsoon(){
        $offer = $this->offer()->first();
        $coming_soon_offer = ComingSoonOffer::create();
        $coming_soon_offer->offer()->save($offer);
        $this->delete();

        return $coming_soon_offer;
    }

    public function sold(){
        $offer = $this->offer()->first();
        $sold_offer = SoldOffer::create();
        $sold_offer->offer()->save($offer);
        $this->delete();

        return $sold_offer;
    }

}
