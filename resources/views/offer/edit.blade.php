@extends('layout.app')

@section('title', 'Edit '.$offer->name)

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post" action="{{route("offer.update",$offer->id)}}"><h2 class="sr-only">Offer</h2>
            <div class="illustration"><ion-icon name="cube-outline"></ion-icon></div>
            @csrf

            @method("PATCH")
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

            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" name="name" placeholder="Name" value="{{$offer->name}}" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input class="form-control" type="number" step="0.01" name="price" value="{{$offer->price}}" placeholder="Price" required min="0">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" type="text" name="description" placeholder="Description">{{$offer->description}}</textarea></div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input class="form-control" type="number" name="stock" value="{{$offer->stock}}" placeholder="Stock" min="0" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                @php($status_list = array("InactiveOffer","SoldOffer","ActiveOffer","ComingSoonOffer"))

                <select name="status" class="form-control" required>
                    @foreach($status_list as $s)
                        <option @if($s == str_replace("App\Models\\","",$offer->status)) selected @endif value="{{$s}}">{{$s}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="parent_id">Parent category</label>
                <select name="parent_id" class="form-control" required>
                    <option value="">No parent</option>
                    @foreach($categories as $c)
                        @if($c->id == $offer->category_id)
                            <option selected value="{{$c->id}}">{{$c->name}} ID : {{$c->id}}</option>
                        @else
                            <option value="{{$c->id}}">{{$c->name}} ID : {{$c->id}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <a class="forgot" href="{{route("offer.index")}}">Get back to offer list.</a>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Update an offer</button>
            </div></form>
    </div>
@stop

