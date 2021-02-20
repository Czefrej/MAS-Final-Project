<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Offer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $discounts = Discount::with(["category","offer"])->get();
        return view('discount.index')->with(["discounts"=>$discounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::withCount('offers')
            ->having('offers_count', '>', 0)
            ->get();;
        $offers = Offer::all();

        return view('discount.create')->with(["categories"=>$categories,"offers"=>$offers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $current_time=\Carbon\Carbon::now();

        $rules = [
            'name'=>'required|max:100',
            'amount'=>'numeric|required',
            'end_date'=>'date_format:"Y-m-d\TH:i"|after_or_equal:'.$current_time,
            'discount_type'=>'in:offer,category'
        ];
        if(isset($request->discount_type)) {
            if ($request->discount_type == "offer")
                $rules["offer_id"] = 'numeric|nullable';
            else if ($request->discount_type == "category")
                $rules["category_id"] = 'numeric|nullable';
        }

        $validateData = $request->validate($rules);

        try{
            if($request->discount_type =="offer"){
                $offer = Offer::where("id", $request->offer_id)->firstOrFail();

                if($offer->price < $request->amount * 2)
                    throw ValidationException::withMessages(['amount' => 'Discount amount has to be <= 50% of initial price.']);

                $count = Discount::where("offer_id","=",$request->offer_id)
                    ->where("end_date",">",DB::RAW("NOW()"))
                    ->count();

                if($count>0){
                    throw ValidationException::withMessages(['offer_id' => 'The following offer already has a discount.']);
                }
            }else if($request->discount_type == "category"){
                $category = Category::withCount('offers')
                    ->having('offers_count','>',"0")
                    ->where("id", $request->category_id)->firstOrFail();
                $count = Discount::where("category_id","=",$request->category_id)
                    ->where("end_date",">",DB::RAW("NOW()"))
                    ->count();

                if($count>0){
                    throw ValidationException::withMessages(['category_id' => 'The following category already has a discount.']);
                }
            }
        }catch (ModelNotFoundException $e){
            if($request->discount_type =="offer"){
                throw ValidationException::withMessages(['offer_id' => 'You have to provide id of an existing offer']);
            }else if($request->discount_type == "category"){
                throw ValidationException::withMessages(['category_id' => 'You have to provide id of a existing category or category has no offers.']);
            }

        }

        $discount = new Discount();

        $discount->name = $request->name;
        $discount->amount = $request->amount;
        $discount->end_date = $request->end_date;
        $discount->type = $request->discount_type;

        if($request->discount_type =="offer"){
            $offer->discounts()->save($discount);
        }else if($request->discount_type == "category"){
            $category->discounts()->save($discount);
        }

        $discount->save();

        return redirect(route("discount.index"))->with('message', 'Discount was successfully created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $validator = Validator::make(["id"=>$id], [
            'id' => ['required', 'numeric'],
        ]);

        if($validator->fails()){
            return redirect(route("discount.index"))->withErrors($validator);
        }

        try {
            $discount = Discount::where("id", $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of an existing offer']);
        }

        $categories = Category::withCount('offers')
            ->having('offers_count', '>', 0)
            ->get();;
        $offers = Offer::all();

        return view('discount.edit')->with(["categories"=>$categories,"offers"=>$offers,"discount"=>$discount]);


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

        try{
            $discount = Discount::where("id",$id)->firstOrFail();
        }catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of a existing category']);
        }


        $rules = [
            'name'=>'required|max:100',
            'amount'=>'numeric|required',
            'discount_type'=>'in:offer,category'
        ];

        if(isset($request->discount_type)) {
            if ($request->discount_type == "offer")
                $rules["offer_id"] = 'numeric|nullable';
            else if ($request->discount_type == "category")
                $rules["category_id"] = 'numeric|nullable';
        }

        $validateData = $request->validate($rules);


        try{
            if($request->discount_type =="offer"){
                $offer = Offer::where("id", $request->offer_id)->firstOrFail();

                if($offer->price < $request->amount * 2)
                    throw ValidationException::withMessages(['amount' => 'Discount amount has to be <= 50% of initial price.']);


            }else if($request->discount_type == "category"){
                $category = Category::withCount('offers')
                    ->having('offers_count','>',"0")
                    ->where("id", $request->category_id)->firstOrFail();

            }
        }catch (ModelNotFoundException $e){
            if($request->discount_type =="offer"){
                throw ValidationException::withMessages(['offer_id' => 'You have to provide id of an existing offer']);
            }else if($request->discount_type == "category"){
                throw ValidationException::withMessages(['category_id' => 'You have to provide id of a existing category or category has no offers.']);
            }

        }

        $discount->name = $request->name;
        $discount->amount = $request->amount;
        $discount->type = $request->discount_type;

        if($request->discount_type =="offer"){
            $offer->discounts()->save($discount);
        }else if($request->discount_type == "category"){
            $category->discounts()->save($discount);
        }

        $discount->save();

        return redirect(route("discount.index"))->with('message', 'Discount was successfully updated.');

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
            $discount = Discount::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of existing discount']);
        }
        $discount->delete();
        return redirect()->back()->with('message', 'Discount was successfully deleted.');
    }
}
