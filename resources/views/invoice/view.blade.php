@extends('layout.app')
@section('body')
    <style>
        .error {
            color: #FF0000;
        }
    </style>

    <body>

        <div class="container" role="document" style="margin-top: 50px">
            <form method="POST" action="{{ route('invoice.update', $invoice->id) }}" id="invoiceForm"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Customer Name</label>
                                    <input class="form-control @error('customer_name') is-invalid @enderror" type="text"
                                        name="customer_name" placeholder="Enter customer name"
                                        value="{{ old('customer_name', $invoice->customer_name) }}" readonly>
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Invoice Date</label>
                                    <input class="form-control @error('invoice_date') is-invalid @enderror" type="date"
                                        name="invoice_date"
                                        value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}" readonly>
                                    @error('invoice_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Due Date</label>
                                    <input class="form-control @error('due_date') is-invalid @enderror" type="date"
                                        name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                                        readonly>
                                    @error('due_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tax (%)</label>
                                    <input class="form-control @error('tax') is-invalid @enderror" type="number"
                                        name="tax" placeholder="Enter tax" value="{{ old('tax', $invoice->tax) }}"
                                        readonly>
                                    @error('tax')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" id="itemsContainer">
                            @foreach ($invoice->items as $index => $item)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Items</label>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <select class="form-control item-select"
                                                    name="items[{{ $index }}][item_id]"
                                                    data-index="{{ $index }}" disabled>
                                                    <option value="" data-rate="">Select Item</option>
                                                    @foreach ($items as $availableItem)
                                                        <option value="{{ $availableItem->id }}"
                                                            data-rate="{{ $availableItem->rate }}"
                                                            {{ $availableItem->id == $item->item_id ? 'selected' : '' }}>
                                                            {{ $availableItem->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control quantity-input"
                                                    name="items[{{ $index }}][quantity]"
                                                    value="{{ old('items.' . $index . '.quantity', $item->quantity) }}"
                                                    placeholder="Quantity" readonly />
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control rate-input"
                                                    name="items[{{ $index }}][rate]"
                                                    value="{{ old('items.' . $index . '.rate', $item->rate) }}"
                                                    placeholder="Rate" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
