<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function invoiceList(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Invoice::with('items');

                if ($request->user_id) {
                    $query->where('user_id', $request->user_id);
                }

                if ($request->invoice_date) {
                    $query->whereDate('invoice_date', $request->invoice_date);
                }

                $invoices = $query->get();

                return DataTables::of($invoices)
                    ->addIndexColumn()
                    ->make(true);
            }
            $users = User::where('role','0')->get();
            return view('admin.invoice_list',compact('users'));
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while fetching the invoices. Please try again later.'], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while fetching the invoices. Please try again later.');
        }
    }
}
