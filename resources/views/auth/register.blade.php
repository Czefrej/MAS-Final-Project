@extends('layout.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">
        <form method="POST" action="{{ route('register') }}"><h2 class="sr-only">Register Form</h2>
            @csrf

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
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

            <div class="illustration"><ion-icon name="person-add-outline"></ion-icon></div>
            <div class="form-group"><input class="form-control" type="text" name="name" placeholder="Username" required></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email" required></div>
            <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group"><input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit">Register</button>
            </div></form>
    </div>
@stop

