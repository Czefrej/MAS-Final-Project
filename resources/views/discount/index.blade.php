@extends('layout.app')

@section('title', 'Discounts list')

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
            <h1 style="text-align: center; margin: 0px 0px 100px 0px; margin-bottom: 30px;">Discounts</h1>
            <header></header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">Name</th>
                        <th class="text-center">Discount subject</th>
                        <th class="text-center">Discount Amount</th>
                        <th class="text-center">End Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discounts as $d)
                        <tr>
                            <td class="text-center">{{$d->name}} (ID : <b>{{$d->id}}</b>)</td>
                            <td class="text-center">
                                @if($d->type=="offer")<span data-toggle="tooltip" data-placement="top" title="Offer id {{$d->offer->id}}">{{$d->offer->name}}</span> @else <span data-toggle="tooltip" data-placement="top" title="Category id {{$d->category->id}}">{{$d->category->name}}</span> @endif
                            </td>
                            <td class="text-center">
                                -{{$d->amount}}
                            </td>
                            <td class="text-center">
                                {{$d->end_date}}
                            </td>
                            <td class="text-center" style="  color: var(--blue);">
                                <a href="{{route("discount.edit",$d->id)}}" class="btn btn-link text-primary">Edit</a>
                                <button class="btn btn-link text-primary" onclick="deleteitem({{$d->id}});return true;">Delete</button>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-group">
                <a href="{{route("discount.create")}}" class="btn btn-primary btn-block" type="submit">Create a discount</a>
            </div></form>
    </div>
@stop

@push('scripts')
    <script>
        function deleteitem(id){
            $('#form').attr('action', "/discount/"+id);
            $('#form').submit();
        }

    </script>

@endpush
