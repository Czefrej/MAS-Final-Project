<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldOffer extends Model
{
    use HasFactory;

    protected $table = "sold_offer";

    public function offer()
    {
        return $this->morphOne(Offer::class, 'offerable');
    }

    public function comingsoon(){
        $offer = $this->offer()->first();
        $coming_soon_offer = ComingSoonOffer::create();
        $coming_soon_offer->offer()->save($offer);
        $this->delete();

        return $coming_soon_offer;
    }

    public function activate(){
        $offer = $this->offer()->first();
        $active_offer = ActiveOffer::create();
        $active_offer->offer()->save($offer);
        $this->delete();

        return $active_offer;
    }

    public function deactivate(){
        $offer = $this->offer()->first();
        $inactive_offer = InactiveOffer::create();
        $inactive_offer->offer()->save($offer);
        $this->delete();

        return $inactive_offer;
    }
}
