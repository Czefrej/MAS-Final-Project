@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="post" action="{{route("deposit.store")}}"><h2 class="sr-only">Deposit funds</h2>
            <div class="illustration"><ion-icon name="card-outline"></ion-icon></div>
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
            <div class="form-group"><input class="form-control" type="number" name="amount" placeholder="Amount"></div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Top-up</button>
            </div>
        </form>
    </div>
@stop

