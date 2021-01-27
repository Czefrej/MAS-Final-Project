@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form method="post" action="{{route("category.store")}}" style="max-width: 700px"><h2 class="sr-only">Category</h2>
            <h2 class="sr-only">Login Form</h2>
            <h1 style="text-align: center; margin: 0px 0px 100px 0px; margin-bottom: 30px;">Categories</h1>
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
                        @foreach($categories as $c)
                        <tr>
                            <td class="text-center">{{$c->name}} (ID : <b>{{$c->id}}</b>)</td>
                            <td class="text-center">
                                @if($c->parent_id != null)
                                    {{$c->parent->name}} (ID : <b>{{$c->parent->id}}</b>)
                                @else
                                    None
                                @endif
                            </td>
                            <td class="text-center" style="  color: var(--blue);">
                                <a class="btn btn-link text-primary">Edit</a>
                                <form method="post" action="{{route("category.destroy",$c->id)}}">
                                    @method("DELETE")
                                    @csrf
                                    <button class="btn btn-link text-primary" type="submit">Delete</button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="form-group">
                <a href="{{route("category.create")}}" class="btn btn-primary btn-block" type="submit">Create a category</a>
            </div></form>
    </div>
@stop

