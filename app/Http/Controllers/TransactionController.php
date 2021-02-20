<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users = User::with("transactions")->get();
        $offers = Offer::where('status',"=","active")->get();

        return view("transactions.index")->with(["users"=>$users,"offers"=>$offers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'offer_id' => ['required', 'numeric'],
            'user_id'=>['required','numeric'],
            'quantity'=>['required','numeric']
        ]);

        if($validator->fails()){
            return response()->json(["error"=>$validator->errors()->first()],400);
        }

        try{
            $user = User::findOrFail($request->user_id);
        }catch(ModelNotFoundException $e){
            return response()->json(["error"=>"Couldn't find a user with a given id."],400);
        }

        try{
            $offer = Offer::with("discounts","category.discounts")
                ->where("status","=","active")->findOrFail($request->offer_id);
        }catch (ModelNotFoundException $e){
            return response()->json(["error"=>"Couldn't find an offer with a given id."],400);
        }

        if($offer->stock < $request->quantity)
            return response()->json(["error"=>"Quantity of transaction is higher than stock of offer!"],400);

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

        $total = $final_price * $request->quantity;

        if($total > $user->balance)
            return response()->json(["error"=>"$user->name got insufficient funds."],400);


        $transaction = new Transaction();
        $transaction->quantity = $request->quantity;
        $transaction->price = $final_price;
        $user->transactions()->save($transaction);
        $offer->transactions()->save($transaction);
        $transaction->save();

        $user->balance -= $total;
        $user->save();


        return response()->json(['success'=>"$user->name bought $request->quantity of $offer->name for $total"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {

            $transactions = User::with("transactions",'transactions.offer')->findOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['error'=>"User with following id doesn't exists"]);
        }



        return response()->json(['result'=>$transactions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(["error"=>"Transaction doesn't exist"],400);
        }

        $transaction->delete();
    }
}
