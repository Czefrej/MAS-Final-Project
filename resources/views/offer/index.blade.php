@extends('layout.app')

@section('title', 'Offers list')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form id="form" method="post" action="{{route("category.store")}}" style="max-width: 700px"><h2 class="sr-only">Offers</h2>
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
            @method("DELETE")
            <h2 class="sr-only">Login Form</h2>
            <h1 style="text-align: center; margin: 0px 0px 100px 0px; margin-bottom: 30px;">Offers</h1>
            <header></header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($offers as $o)
                        <tr>
                            <td class="text-center">{{$o->name}} (ID : <b>{{$o->id}}</b>)</td>
                            <td class="text-center">
                                {{$o->stock}}
                            </td>
                            <td class="text-center">
                                {{$o->price}}
                            </td>
                            <td class="text-center">
                                {{$o->status}}
                            </td>
                            <td class="text-center" style="  color: var(--blue);">
                                <a href="{{route("offer.edit",$o->id)}}" class="btn btn-link text-primary">Edit</a>
                                <button class="btn btn-link text-primary" onclick="deleteitem({{$o->id}});return true;">Delete</button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <a href="{{route("offer.create")}}" class="btn btn-primary btn-block" type="submit">Create an offer</a>
            </div></form>
    </div>
@stop

@push('scripts')
    <script>
        function deleteitem(id){
            $('#form').attr('action', "/offer/"+id);
            $('#form').submit();
        }

    </script>

@endpush
