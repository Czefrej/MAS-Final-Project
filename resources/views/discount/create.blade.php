@extends('layout.app')

@section('title', 'Create discount')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post" action="{{route("discount.store")}}"><h2 class="sr-only">Discount</h2>
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

            <div class="form-group"><input class="form-control" type="text"  name="name" placeholder="Name" required></div>
            <div class="form-group"><input class="form-control" type="number" step="0.01" name="amount" placeholder="Amount" required></div>
            <div class="form-group">
                <label>End date</label>
                <input class="form-control" type="datetime-local" name="end_date" placeholder="End date" required>
            </div>
            <div class="form-group">
                <select class="form-control" id="discount-type" name="discount_type"  required>
                    <option>Discount type</option>
                    <option value="offer">Offer</option>
                    <option value="category">Category</option>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" hidden id="offer_id" name="offer_id">
                    <option>Select an offer</option>
                    @foreach($offers as $o)
                        <option value="{{$o->id}}">{{$o->name}} (ID: <b>{{$o->id}}</b>)</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <select class="form-control" hidden id="category_id" name="category_id">
                    <option>Select a category</option>
                    @foreach($categories as $c)
                        <option value="{{$c->id}}">{{$c->name}} (ID: <b>{{$c->id}}</b>)</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create a discount</button>
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
