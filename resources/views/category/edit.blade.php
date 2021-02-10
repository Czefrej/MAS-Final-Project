@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form method="post" action="{{route("category.update",$category->id)}}"><h2 class="sr-only">Category</h2>
            @csrf

            @method("PATCH")
            <div class="illustration"><ion-icon name="apps-outline"></ion-icon></div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="form-group"><input class="form-control" type="text" name="name" value="{{$category->name}}" placeholder="Name"></div>
            <div class="form-group">
                <label for="parent_id">Parent category</label>
                <select name="parent_id" class="form-control">
                    @if($category->parent_id == null)
                        <option selected value="">No parent</option>
                    @else
                        <option value="">No parent</option>
                    @endif
                    @foreach($categories as $c)
                        @if($c->id == $category->parent_id)
                            <option selected value="{{$c->id}}">{{$c->name}} ID : {{$c->id}}</option>
                        @else
                            <option value="{{$c->id}}">{{$c->name}} ID : {{$c->id}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <a class="forgot" href="{{route("category.index")}}">Get back to category list.</a>


            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Update a category</button>
            </div></form>
    </div>
@stop

