@extends('layout.app')

@section('title', 'Offer create')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post" action="{{route("offer.store")}}"><h2 class="sr-only">Offer</h2>
            <div class="illustration"><ion-icon name="cube-outline"></ion-icon></div>
            @csrf
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

            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name" required></div>
            <div class="form-group"><input class="form-control" type="number" step="0.01" name="price" placeholder="Price" required min="0"></div>
            <div class="form-group"><textarea class="form-control" type="text" name="description" placeholder="Description"></textarea></div>
            <div class="form-group"><input class="form-control" type="number" name="stock" placeholder="Stock" min="0" required>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent category</label>
                <select name="parent_id" class="form-control" required>
                    <option value="">No parent</option>
                    @foreach($categories as $c)
                        <option value="{{$c->id}}">{{$c->name}} ID : {{$c->id}}</option>
                    @endforeach
                </select>
            </div>

            <a class="forgot" href="{{route("offer.index")}}">Get back to offer list.</a>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create an offer</button>
            </div></form>
    </div>
@stop

