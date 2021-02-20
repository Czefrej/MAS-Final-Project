@extends('layout.app')

@section('title', 'Edit '.$discount->name)

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post" action="{{route("discount.update",$discount->id)}}"><h2 class="sr-only">Discount</h2>
            @csrf

            @method("PATCH")
            <div class="illustration"><ion-icon name="pricetag-outline"></ion-icon></div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

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

            @csrf

            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" name="name" value="{{$discount->name}}" placeholder="Name" required>
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input class="form-control" type="number" name="amount" step="0.01" value="{{$discount->amount}}" placeholder="Amount" required>
            </div>
            <div class="form-group">
                <label>End date</label>
                <input class="form-control" type="text" name="end_date" value="{{$discount->end_date}}" disabled placeholder="End date" required>
            </div>
            <div class="form-group">
                <label>Discount type</label>
                <select class="form-control" id="discount-type" name="discount_type" required>
                    <option>Discount type</option>
                    @if($discount->type =="offer")
                        <option value="offer" selected>Offer</option>
                        <option value="category">Category</option>
                    @else
                        <option value="offer">Offer</option>
                        <option value="category" selected>Category</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" @if($discount->type == "category") hidden @endif id="offer_id" name="offer_id">
                    <option>Select an offer</option>
                    @foreach($offers as $o)
                        @if($o->id == $discount->offer_id)
                            <option selected value="{{$o->id}}">{{$o->name}} (ID: <b>{{$o->id}}</b>)</option>
                        @else
                            <option value="{{$o->id}}">{{$o->name}} (ID: <b>{{$o->id}}</b>)</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <select class="form-control" @if($discount->type == "offer") hidden @endif id="category_id" name="category_id" >
                    <option>Select a category</option>
                    @foreach($categories as $c)
                        @if($o->id == $discount->offer_id)
                            <option selected value="{{$c->id}}">{{$c->name}} (ID: <b>{{$c->id}}</b>)</option>
                        @else
                            <option value="{{$c->id}}">{{$c->name}} (ID: <b>{{$c->id}}</b>)</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Update a discount</button>
            </div></form>
    </div>
@stop

@push('scripts')
    <script>
        $( "#discount-type" ).change(function() {
            var discount_type = $( "#discount-type" ).val();
            if(discount_type === "offer"){
                $('#offer_id').attr('hidden', false);
                $('#category_id').attr('hidden', true);
            }else if (discount_type === "category"){
                $('#offer_id').attr('hidden', true);
                $('#category_id').attr('hidden', false);
            }else{
                $('#offer_id').attr('hidden', true);
                $('#category_id').attr('hidden', true);
            }
        });

    </script>

@endpush
