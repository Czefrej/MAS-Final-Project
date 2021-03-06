<!doctype html>
<html lang="en">
    <head>
        <title>Web store - @yield('title')</title>
        <!-- CSS only -->

        @stack('head')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
        <link href="{{ asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
        @php
            $categories = \App\Models\Category::where("parent_id","=",null)->get();
        @endphp
        @section('sidebar')
            <nav class="navbar navbar-light navbar-expand-md navigation-clean">
                <div class="container"><a class="navbar-brand" href="#"><b>Web Store</b></a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Products </a>
                                <div class="dropdown-menu">
                                    @foreach($categories as $c)
                                        <a class="dropdown-item" href="/product/{{$c->id}}">{{$c->name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            @guest
                            <li class="nav-item"><a class="nav-link" href="{{route("login")}}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{route("register")}}">Register</a></li>
                            @else
                                @if(Auth::user()->role == "admin")
                                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Administration </a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route("category.index")}}">Categories</a>
                                            <a class="dropdown-item" href="{{route("offer.index")}}">Offers</a>
                                            <a class="dropdown-item" href="{{route("discount.index")}}">Discounts</a>
                                        </div>
                                    </li>
                                @endif
                                <li class="nav-item"><a class="nav-link" href="{{route("logout")}}">Logout</a></li>
                                <li class="nav-item"><a class="nav-link text-primary" href="{{route("deposit.index")}}">
                                {{ Auth::user()->balance }}$ (Deposit)</a></li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @show

        @yield('content')
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
        @include('includes.footer')
    </body>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @stack('scripts')
</html>
