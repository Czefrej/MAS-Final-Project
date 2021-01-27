@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form method="post" action="{{route("category.store")}}"><h2 class="sr-only">Category</h2>
            <h2 class="sr-only">Login Form</h2>
            <h1 style="  text-align: center;
  margin: 0px 0px 100px 0 px;
  margin-bottom: 30px;
">Categories</h1>
            <header></header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Parent Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">Cell 1</td>
                        <td class="text-center">Cell 2</td>
                        <td class="text-center" style="  color: var(--blue);
">Edit Delete
                        </td>
                    </tr>
                    <tr></tr>
                    </tbody>
                </table>
            </div>
            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name"></div>
            <div class="form-group">
                <label for="parent_id">End date</label>
                <select name="parent_id" class="form-control">
                    <option value="12">No parent</option>
                    @foreach($categories as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create a category</button>
            </div></form>
    </div>
@stop

