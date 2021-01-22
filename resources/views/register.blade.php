@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post"><h2 class="sr-only">Register Form</h2>
            <div class="illustration"><ion-icon name="person-add-outline"></ion-icon></div>
            <div class="form-group"><input class="form-control" type="text" name="username" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password">
            </div>
            <div class="form-group"><input class="form-control" type="password" name="re-password" placeholder="Confirm password">
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Register</button>
            </div></form>
    </div>
@stop

