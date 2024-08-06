<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $invoiceCount = $user->role == 1 ? Invoice::count() : Invoice::where('user_id', $user->id)->count();
        return view('dashboard',compact('invoiceCount'));
    }


}
