@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post"><h2 class="sr-only">Discount</h2>
            <div class="illustration"><ion-icon name="pricetag-outline"></ion-icon></div>
            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name"></div>
            <div class="form-group"><input class="form-control" type="number" name="amount" placeholder="Amount"></div>
            <div class="form-group">
                <label>End date</label>
                <input class="form-control" type="date" name="end-date" placeholder="End date">
            </div>
            <div class="form-group">
                <select class="form-control">
                    <option>Discount type</option>
                    <option>Offer</option>
                    <option>Category</option>
                </select>
            </div>
            {{--            <div class="form-group">--}}
            {{--                <select class="form-control">--}}
            {{--                    <option>Offer</option>--}}
            {{--                    <option>First</option>--}}
            {{--                </select>--}}
            {{--            </div>--}}

            <div class="form-group">
                <select class="form-control">
                    <option>Category</option>
                    <option>First</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create a discount</button>
            </div></form>
    </div>
@stop

