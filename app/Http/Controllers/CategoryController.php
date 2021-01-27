<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        //
        dd($id);
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
        dd($id);
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
