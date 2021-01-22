@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post"><h2 class="sr-only">Register Form</h2>
            <div class="illustration"><ion-icon name="cube-outline"></ion-icon></div>
            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Name"></div>
            <div class="form-group"><input class="form-control" type="number" name="price" placeholder="Price"></div>
            <div class="form-group"><textarea class="form-control" type="text" name="description" placeholder="Description"></textarea></div>
            <div class="form-group"><input class="form-control" type="number" name="stock" placeholder="Stock">
            </div>
            <div class="form-group">
                <select class="form-control">
                    <option>Category</option>
                    <option>First</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Create an offer</button>
            </div></form>
    </div>
@stop

