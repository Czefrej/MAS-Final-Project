<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('category.index')->with(["categories"=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $categories = Category::all();

        return view('category.create')->with(["categories"=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'=>'required|max:100',
            'parent_id'=>'numeric|nullable'
        ]);
        if($request->parent_id != null) {
            try {
                Category::where("id", $request->parent_id)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                throw ValidationException::withMessages(['parent_id' => 'You have to provide id of a existing category']);
            }
        }



        $category = new Category;
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->save();

        return redirect(route("category.index"))->with('message', 'Category was successfully created.');
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
        dd($id);
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
            return redirect(route("category.index"))->withErrors($validator);
        }

        try {
            $category = Category::where("id", $id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of a existing category']);
        }


        $categories = Category::where('id',"!=",$category->id)->where(function($query) use($category){
            $query->where('parent_id','!=',$category->id)
                ->orWhereNull('parent_id','is',null);
        })->get();


        return view('category.edit')->with(["category"=>$category,"categories"=>$categories]);

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
            'parent_id'=>'numeric|nullable'
        ]);

        if($request->parent_id != null) {
            try {
                $parent = Category::where("id", $request->parent_id)->firstOrFail();
                if($parent->parent_id == $id)
                    throw ValidationException::withMessages(['parent_id' => 'Parent category cannot be subcategory of this category']);
            } catch (ModelNotFoundException $e) {
                throw ValidationException::withMessages(['parent_id' => 'You have to provide id of a existing category']);
            }
        }

        $category = Category::find($id);
        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->save();

        return redirect(route("category.index"))->with('message', 'Category was successfully updated.');
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
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw ValidationException::withMessages(['id' => 'You have to provide id of existing category']);
        }
        $category->delete();
        return redirect()->back()->with('message', 'Category was successfully deleted.');
    }
}
