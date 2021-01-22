@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post"><h2 class="sr-only">Deposit funds</h2>
            <div class="illustration"><ion-icon name="card-outline"></ion-icon></div>
            <div class="form-group"><input class="form-control" type="number" name="amount" placeholder="Amount"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Top-up</button>
            </div></form>
    </div>
@stop

