@extends('layout.app')

@section('title', 'Home')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="features-boxed">
        <div class="container">
            <div class="intro"><h2 class="text-center">Products </h2>
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

                @foreach($categories as $c)
                    @if(isset($current_category))
                        @if($c->id != $current_category->id)
                            <a href="/product/{{$c->id}}" class="category">{{$c->name}}</a>
                        @endif
                        @else
                            <a href="/product/{{$c->id}}" class="category">{{$c->name}}</a>
                    @endif
                @endforeach
                <br>
                @if(isset($current_category))
                    <a href="/product/{{$current_category->parent_id}}" class="category"> <- Back to previous page</a>

                    <br><small>Current category: {{$current_category->name}}</small>
                @endif
                </div>
            <div class="row justify-content-center features">
                @php($i = 0)
                @foreach($categories as $c)
                    @foreach($c->offers as $o)
                        @if(isset($current_category))
                            @if($o->category_id != $current_category->id)
                                @continue;
                            @endif
                        @endif

                        @php($i++)
                        @php($category_discount = 0)
                        @if(sizeof($c->discounts) > 0)
                            @php($category_discount = $c->discounts[0]->amount)
                        @endif

                        <div class="col-sm-6 col-md-5 col-lg-4 item">
                            <div class="box"><i class="fa fa-map-marker icon"></i>
                                <h3 class="name">{{$o->name}}</h3>
                                <br>
                                <h4><b>
                                        @if(sizeof($o->discounts) > 0)
                                            @if($category_discount>$o->discounts[0]->amount)
                                                @if($o->price - $category_discount > 0)
                                                    {{$o->price - $category_discount}}$
                                                @else
                                                    0$
                                                @endif
                                            @else
                                                @if($o->price - $o->discounts[0]->amount > 0)
                                                    {{$o->price - $o->discounts[0]->amount}}$
                                                @else
                                                    0$
                                                @endif
                                            @endif
                                        @elseif($category_discount >0)
                                            @if($o->price - $category_discount > 0)
                                                {{$o->price - $category_discount}}$
                                            @else
                                                0$
                                            @endif
                                        @else
                                            {{$o->price}}$
                                        @endif
                                    </b></h4>
                                @if(sizeof($o->discounts) > 0 or $category_discount >0)
                                    <small class="red"><s><b>{{$o->price}}$
                                    </b></s></small>
                                @endif
                                <h4>
                                    @switch($o->status)
                                        @case("ComingSoon")
                                            <span class="green">Coming soon</span>
                                        @break
                                        @case("SoldOut")
                                        <span class="red">Sold Out</span>
                                        @break
                                    @endswitch
                                </h4>
                                <p class="description">{{$o->description}}</p>
                                <a class="btn btn-primary btn-block" href="/buy/{{$o->id}}" type="submit">Buy</a>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                @if($i==0)
                    <h1>No results</h1>
                @endif
            </div>
        </div>
    </div>
@stop
