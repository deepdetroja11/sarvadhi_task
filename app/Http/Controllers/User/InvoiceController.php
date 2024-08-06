<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceCreateRequest;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->id;
        if ($request->ajax()) {
            $query = Invoice::where('user_id', $user)->with('items');

            if ($request->has('status') && $request->status !== null) {
                $status = $request->status;
                $query->where('status', $status);
            }

            if ($request->invoice_date) {
                $query->whereDate('invoice_date', $request->invoice_date);
            }

            $invoices = $query->get();

            return DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit_url = route('invoice.edit', $row->id);
                    $view_url = route('invoice.show', $row->id);
                    $download_url = route('invoice.download', ['id' => $row->id, 'download' => true]);
                    $email_url = route('invoice.email', $row->id);
                    $action_btn = "
                    <a href='{$view_url}' class='action-btns1 mr-2'><i class='fe fe-eye text-info' data-toggle='tooltip' data-placement='top' title='View'></i></a>
                    <a href='{$edit_url}' class='action-btns1 mr-2'><i class='fe fe-edit text-primary' data-toggle='tooltip' data-placement='top' title='Edit'></i></a>
                    <a href='javascript:void(0);' onclick='deleteInvoice({$row->id})' class='action-btns1 mr-2' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fe fe-trash-2 text-danger'></i></a>
                    <a href='{$download_url}' class='action-btns1 mr-2' data-toggle='tooltip' data-placement='top' title='Download PDF' style='color:blue'><i class='fe fe-download'></i></a>
            <a href='javascript:void(0);' onclick='sendInvoiceEmail({$row->id}, this)' class='action-btns1 mr-2' data-toggle='tooltip' data-placement='top' title='Send Email' style='color:green'><i class='fe fe-mail'></i></a>";
                    return $action_btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        return view('invoice.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceCreateRequest $request)
    {
        $validated = $request->validated();
        try {
            $invoice = Invoice::create([
                'customer_name' => $validated['customer_name'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'tax' => $validated['tax'],
                'user_id' => Auth::id(),
                'status' => $validated['status'],
            ]);

            $totalAmount = 0;

            foreach ($validated['items'] as $index => $itemData) {
                $rate = $request->input("items.{$index}.rate_hidden");
                $itemTotal = $itemData['quantity'] * $rate;
                $totalAmount += $itemTotal;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'rate' => $rate,
                ]);
            }

            $totalAmountWithTax = $totalAmount + ($totalAmount * ($validated['tax'] / 100));

            $invoice->update(['total' => $totalAmountWithTax]);

            return redirect()->route('invoice.index')->with('success', 'Invoice created successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors('One or more items not found.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Database error occurred. Please try again.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An unexpected error occurred. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $items = Item::all();
        $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
        $invoice->due_date = Carbon::parse($invoice->due_date);
        return view('invoice.view', compact('invoice', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $items = Item::all();
        $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
        $invoice->due_date = Carbon::parse($invoice->due_date);
        return view('invoice.edit', compact('invoice', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceCreateRequest $request, string $id)
    {
        $validated = $request->validated();
        try {
            $invoice = Invoice::findOrFail($id);

            $invoice->update([
                'customer_name' => $validated['customer_name'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'tax' => $validated['tax'],
            ]);

            $totalAmount = 0;

            foreach ($validated['items'] as $index => $itemData) {
                $rate = $request->input("items.{$index}.rate_hidden");
                $itemTotal = $itemData['quantity'] * $rate;
                $totalAmount += $itemTotal;

                $invoiceItem = InvoiceItem::where('invoice_id', $invoice->id)
                    ->where('item_id', $itemData['item_id'])
                    ->first();

                if ($invoiceItem) {
                    $invoiceItem->update([
                        'quantity' => $itemData['quantity'],
                        'rate' => $rate,
                    ]);
                } else {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_id' => $itemData['item_id'],
                        'quantity' => $itemData['quantity'],
                        'rate' => $rate,
                    ]);
                }
            }

            $totalAmountWithTax = $totalAmount + ($totalAmount * ($validated['tax'] / 100));

            $invoice->update(['total' => $totalAmountWithTax]);
            return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully.');
        } catch (ModelNotFoundException $e) {
            dd($e);
            return redirect()->back()->withErrors('Invoice not found.');
        } catch (QueryException $e) {
            dd($e);
            return redirect()->back()->withErrors('Database error occurred. Please try again.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors('An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->items()->delete();
            $invoice->delete();
            return response()->json(['success' => true, 'message' => 'Invoice deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete invoice.'], 500);
        }
    }


    public function download(Request $request, $id)
    {
        try {
            $invoice = Invoice::with('items')->findOrFail($id);
            $items = DB::table('items')->get();

            $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
            $invoice->due_date = Carbon::parse($invoice->due_date);

            view()->share('invoice', $invoice);

            $pdf = Pdf::loadView('invoice.pdfview', compact('invoice'));
            return $pdf->download('invoice_' . $invoice->id . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('An error occurred while generating the PDF.');
        }
    }

    public function sendEmail($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        $invoice->invoice_date = Carbon::parse($invoice->invoice_date);
        $invoice->due_date = Carbon::parse($invoice->due_date);

        $items = DB::table('items')->get();

        $pdf = PDF::loadView('invoice.pdfview', compact('invoice', 'items'))->output();

        $data = [
            'email' => $invoice->user->email,
            'title' => 'Your Invoice',
            'body' => 'Attached is your invoice.',
            'invoice' => $invoice
        ];


        Mail::send('emails.invoice', $data, function ($message) use ($data, $pdf) {
            $message->to($data['email'])
                ->subject($data['title'])
                ->attachData($pdf, 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);
        });


        return response()->json(['success' => 'Test email sent successfully!']);
    }
}
