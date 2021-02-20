<?php

namespace App\Http\Controllers;

use App\Models\ActiveOffer;
use App\Models\Category;
use App\Models\ComingSoonOffer;
use App\Models\InactiveOffer;
use App\Models\Offer;
use App\Models\SoldOffer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::all();


        return view('offer.index')->with(["offers"=>$offers]);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('offer.create')->with(["categories"=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->stock = (int) $request->stock;

        $validateData = $request->validate([
            'name'=>'required|max:100',
            'parent_id'=>'numeric|required',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric|min:0',
            'description'=>'max:8000|nullable',

        ]);

        try {
            $cat = Category::where("id", $request->parent_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['parent_id' => 'You have to provide id of a existing category']);
        }

//        switch ($request->offer){
//            case "ActiveOffer":
//                $offer_type = ActiveOffer::create();
//                break;
//            case "ComingSoonOffer":
//                $offer_type = ComingSoonOffer::create();
//                break;
//            case "InactiveOffer":
//                $offer_type = InactiveOffer::create();
//                break;
//            case "SoldOffer":
//                $offer_type = SoldOffer::create();
//                break;
//        }
        $offer_type = InactiveOffer::create();
        $offer = new Offer;
        $offer->name = $request->name;
        $offer->price = $request->price;
        $offer->stock = $request->stock;
        $offer->description = $request->description;
        $offer->category_id = $request->parent_id;
        $offer->offerable_type = "App\Models\Inactive";
        $offer->offerable_id = $offer_type->id;
        Auth::user()->createdOffers()->save($offer);
        $cat->offers()->save($offer);
        $offer_type->offer()->save($offer);
        $offer->save();

        return redirect(route("offer.index"))->with('message', 'Offer was successfully created.');
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
            return redirect(route("offer.index"))->withErrors($validator);
        }

        try {
            $offer = Offer::where("id", $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of an existing offer']);
        }


        $categories = Category::all();


        return view('offer.edit')->with(["offer"=>$offer,"categories"=>$categories]);

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
        $validateData = $request->validate([
            'name'=>'required|max:100',
            'parent_id'=>'numeric|required',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric|min:0',
            'description'=>'max:8000|nullable',
            'status'=>'required|max:100|in:ActiveOffer,InactiveOffer,SoldOffer,ComingSoonOffer'
        ]);
        try{
            $category = Category::where("id",$request->parent_id)->firstOrFail();

        }catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['parent_id' => 'You have to provide id of a existing category']);
        }

        $offer = Offer::find($id);
        $offer->name = $request->name;
        $offer->stock = $request->stock;
        $offer->description = $request->description;
        $offer->price = $request->price;
        $category->offers()->save($offer);
        $offer->save();
        if(str_replace("App\Models\\","",$offer->offerable_type) != $request->status) {
            $offerable = $offer->offerable()->first();
            switch ($request->status) {
                case "ActiveOffer":
                    $offerable->activate();
                    break;
                case "ComingSoonOffer":
                    $offerable->comingsoon();
                    break;
                case "InactiveOffer":
                    $offerable->deactivate();
                    break;
                case "SoldOffer":
                    $offerable->sold();
                    break;
            }
        }

        return redirect(route("offer.index"))->with('message','Offer was successfully updated.');
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
            $offer = Offer::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of existing offer']);
        }
        $offer->offerable()->first()->delete();
        $offer->delete();
        return redirect()->back()->with('message', 'Offer was successfully deleted.');
    }
}
