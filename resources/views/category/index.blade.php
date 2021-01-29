@extends('layout.app')

@section('title', 'Categories list')

@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form id="form" method="post" action="{{route("category.store")}}" style="max-width: 700px"><h2 class="sr-only">Category</h2>
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
            <h1 style="text-align: center; margin: 0px 0px 100px 0px; margin-bottom: 30px;">Categories</h1>
            <header></header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Parent Category</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $c)
                        <tr>
                            <td class="text-center">{{$c->name}} (ID : <b>{{$c->id}}</b>)</td>
                            <td class="text-center">
                                @if($c->parent_id != null)
                                    {{$c->parent->name}} (ID : <b>{{$c->parent->id}}</b>)
                                @else
                                    None
                                @endif
                            </td>
                            <td class="text-center" style="  color: var(--blue);">
                                <a href="{{route("category.edit",$c->id)}}" class="btn btn-link text-primary">Edit</a>
                                <button class="btn btn-link text-primary" onclick="deleteitem({{$c->id}});return true;">Delete</button>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <a href="{{route("category.create")}}" class="btn btn-primary btn-block" type="submit">Create a category</a>
            </div></form>
    </div>
@stop

@push('scripts')
    <script>
        function deleteitem(id){
            $('#form').attr('action', "/category/"+id);
            $('#form').submit();
        }

    </script>

@endpush