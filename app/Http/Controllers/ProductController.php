<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index($category_id = null){
        $validator = Validator::make(["id"=>$category_id], [
            'id' => [ 'numeric','nullable'],
        ]);

        if($validator->fails()){
            return redirect("product")->withErrors($validator);
        }

        $categories = Category::with("offers.discounts","discounts")
            ->where('parent_id',$category_id)
            ->orWhere("id",$category_id)
            ->get();

        $category = null;
        if(sizeof($categories )== 0)
            return redirect("/product");

        foreach ($categories as $cat){
            if($category_id == $cat->id)
                $category = $cat;
        }
        return view('home')->with(["categories"=>$categories,'current_category'=>$category]);
    }
}
