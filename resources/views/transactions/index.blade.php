@extends('layout.app')

@section('title', 'Transaction ;ost')
@push('head')
    <meta name="_token" content="{{csrf_token()}}" />
@endpush
@section('sidebar')
    @parent

@stop

@section('content')
    <div class="login-clean">

        <form id="form" method="post" novalidate action="#" style="max-width: 700px"><h2 class="sr-only">Category</h2>
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

            <h2 class="sr-only">Login Form</h2>
            <h1 style="text-align: center; margin: 0px 0px 100px 0px; margin-bottom: 30px;">Users</h1>
            <header></header>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">User</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Balance</th>
                        <th class="text-center">Transactions</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td class="text-center"><span data-toggle="tooltip" data-placement="top" title="ID {{$u->id}}">{{$u->name}}</span></td>
                            <td class="text-center">
                                {{$u->email}}
                            </td>
                            <td class="text-center">
                                {{$u->role}}
                            </td>
                            <td class="text-center">
                                {{$u->balance}}
                            </td>
                            <td class="text-center">
                                    {{sizeof($u->transactions)}}

                            </td>
                            <td class="text-center">
                                <input name="userID" value="{{$u->id}}" type="checkbox">
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Transactions</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">User</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Total price</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="transactions-table">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="add-transaction-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add transaction</h5>
                                <button type="button" class="close exit-modal" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" id="error-transaction-add" hidden>

                                </div>
                                <div class="alert alert-success" id="success-transaction-add" hidden>

                                </div>
                                <div class="form-group">
                                    <select class="form-control" id="offer_id" name="offer_id">
                                        <option value="">Select an offer</option>
                                        @foreach($offers as $o)
                                            <option value="{{$o->id}}">{{$o->name}} (ID: <b>{{$o->id}}</b>)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="quantity" type="number" step="1" name="qty" placeholder="Quantity" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary exit-modal"  data-dismiss="modal">Close</button>
                                <button type="button" id="add-transaction" class="btn btn-primary">Save transaction</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group text-center">
                        <button type="button" id="show-transactions" class="btn btn-primary action" data-toggle="modal" data-target="#exampleModal">
                            Show transactions
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary action" data-toggle="modal" data-target="#add-transaction-modal">
                            Add transactions
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
    <script>
        var userIDs = []


        function deleteitem(id){
            $('#form').attr('action', "/discount/"+id);
            $('#form').submit();
        }

        $(document).ready(function(){
            //SHOW TRANSACTION
            $(".action").click(function(){
                userIDs = []
                $("input:checkbox[name=userID]:checked").each(function(){
                    if(!userIDs.includes($(this).val()))
                        userIDs.push($(this).val());
                });

            });


            jQuery('#show-transactions').click(function(e){
                if(userIDs.length == 0) {
                    alert("Select some users first!");
                    return false;
                }
                e.preventDefault();
                $("#transactions-table").html('');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                userIDs.forEach(function(entry) {
                    jQuery.ajax({
                        url: "/transaction/"+entry,
                        method: 'get',
                        // data: {
                        //     name: jQuery('#name').val(),
                        //     type: jQuery('#type').val(),
                        //     price: jQuery('#price').val()
                        // },
                        success: function(result){
                            for(var k in result['result']['transactions']) {
                                transaction = result['result']['transactions'][k];
                                offer = transaction['offer'];


                                $("#transactions-table").append('<tr id="row'+transaction['id']+'">' +
                                    '<td class="text-center">'+result['result']['name']+'</td>' +
                                    '<td class="text-center">'+offer['name']+'</td>' +
                                    '<td class="text-center">'+transaction['quantity']+'</td>' +
                                    '<td class="text-center">'+Math.round(transaction['quantity']*transaction['price']*100)/100+'</td>' +
                                    '<td class="text-center"><button type="button" class="btn red delete-transaction" id="'+transaction['id']+'">Delete</button></td>'+
                                    '</tr>');
                            }
                        }});
                });
            });

            $('.exit-modal').click(function (e) {
                $("#success-transaction-add").html('');
                $("#success-transaction-add").attr('hidden',true);
                $("#error-transaction-add").html('');
                $("#error-transaction-add").attr('hidden',true);
            });


            //ADD TRANSACTION

            $('#add-transaction').click(function(e) {
                if(userIDs.length == 0) {
                    alert("Select some users first!");
                    return false;
                }


                offer_id = jQuery('#offer_id').val();
                qty = jQuery('#quantity').val();
                if(qty<=0) {
                    $("#error-transaction-add").html('Quantity must be bigger than 0.');
                    $("#error-transaction-add").attr('hidden',false);
                    return false;
                }

                if(offer_id.length == 0) {
                    $("#error-transaction-add").html('You have to select an offer');
                    $("#error-transaction-add").attr('hidden',false);
                    return false;
                }

                $("#error-transaction-add").attr('hidden',true);

                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                userIDs.forEach(function(entry) {
                    user = entry;
                    jQuery.ajax({
                        url: "/transaction",
                        method: 'post',
                        data: {
                            quantity: qty,
                            offer_id: offer_id,
                            user_id: user
                        },
                        success: function (result) {
                            $("#success-transaction-add").append(result['success']+"<br>");
                            $("#success-transaction-add").attr('hidden',false);

                        },
                        error: function (xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            $("#error-transaction-add").html(err['error']);
                            $("#error-transaction-add").attr('hidden', false);
                        }
                    });
                });
            });

            //DELETE TRANSACTION

            $(document).on('click', '.delete-transaction',function(e) {
                transaction_id = e.target.id;
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "/transaction/"+transaction_id,
                    method: 'post',
                    data: {
                        id: transaction_id,
                        _method: 'delete'
                    },
                    success: function (result) {
                        $("#row"+transaction_id).html('');
                    },
                    error: function (xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                    }
                });
            });

        });

    </script>

@endpush
