<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BuyController extends Controller
{
    //
    public function purchase($id){
        $validator = Validator::make(["id"=>$id], [
            'id' => [ 'numeric','required'],
        ]);

        try{
            $offer = Offer::with("discounts","category.discounts","transactions")->findOrFail($id);
        }catch (ModelNotFoundException $e) {
            return redirect("/product");
        }

        $offer_discount = 0;
        $category_discount = 0;
        $discount = 0;
        $final_price = 0;

        if(sizeof($offer->discounts)>0){
            $offer_discount = $offer->discounts[0]->amount;
        }

        if(sizeof($offer->category->discounts)>0){
            $category_discount = $offer->category->discounts[0]->amount;
        }

        if($offer_discount > $category_discount)
            $discount = $offer_discount;
        else $discount = $category_discount;

        $final_price = $offer->price - $discount;

        if ($final_price <0)
            $final_price = 0;
        $user = Auth::user();


        if($final_price>$user->balance){
            throw ValidationException::withMessages(['balance' => 'You have insufficient funds.']);
        }


        $transaction = new Transaction;
        $transaction->quantity = 1;
        $transaction->price = $final_price;
        $offer->transactions()->save($transaction);
        $user->transactions()->save($transaction);
        $transaction->save();

    }
}
