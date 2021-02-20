<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    //
    public function index(){
        return view('deposit');
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'amount'=>'required|integer|min:0'

        ]);

        if(Auth::user()){
            $user = Auth::user();
            $user->balance += $request->amount;
            $user->save();
            return redirect(route("deposit.index"))->with('message', 'Account was successfully topped up.');
        }else return abort(401);
    }
}
