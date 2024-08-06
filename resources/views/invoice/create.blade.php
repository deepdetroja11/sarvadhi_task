@extends('layout.app')
@section('body')
    <style>
        .error {
            color: #FF0000;
        }
    </style>

    <body>
        <div class="page-header d-xl-flex d-block">
            <div class="page-leftheader">
                <h4 class="page-title">Add<span class="font-weight-normal text-muted ml-2">Invoice</span></h4>
            </div>
        </div>
        <div class="container" role="document">
            <form method="POST" action="{{ route('invoice.store') }}" id="invoiceForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Customer Name</label>
                                    <input class="form-control @error('customer_name') is-invalid @enderror" type="text"
                                        name="customer_name" placeholder="Enter customer name"
                                        value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Invoice Date</label>
                                    <input class="form-control @error('invoice_date') is-invalid @enderror" type="date"
                                        name="invoice_date" value="{{ old('invoice_date') }}">
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
                                        name="due_date" value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tax (%)</label>
                                    <input class="form-control @error('tax') is-invalid @enderror" type="number"
                                        name="tax" placeholder="Enter tax" value="{{ old('tax') }}">
                                    @error('tax')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row" id="itemsContainer">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Items</label>
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <select class="form-control item-select" name="items[0][item_id]"
                                                data-index="0">
                                                <option value="" data-rate="">Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" data-rate="{{ $item->rate }}"
                                                        {{ old('items.0.item_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('items.0.item_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number"
                                                class="form-control quantity-input @error('items.0.quantity') is-invalid @enderror"
                                                name="items[0][quantity]" placeholder="Quantity"
                                                value="{{ old('items.0.quantity') }}" />
                                            @error('items.0.quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control rate-input" name="items[0][rate]"
                                                placeholder="Rate" readonly />
                                            <input type="hidden" name="items[0][rate_hidden]" class="rate-hidden-input" />
                                            @error('items.0.rate')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Payment Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="paid"
                                            value="1">
                                        <label class="form-check-label" for="paid">
                                            Paid
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="unpaid"
                                            value="0">
                                        <label class="form-check-label" for="unpaid">
                                            Unpaid
                                        </label>
                                    </div>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group text-right">
                                <button class="btn btn-success" type="submit" name="save">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection

    @section('script')
        <script src="{{ asset('assets') }}/admin/plugins/js-validation/jquery.validate.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.item-select').forEach(function(select) {
                    select.addEventListener('change', function() {
                        let index = this.getAttribute('data-index');
                        let rate = this.options[this.selectedIndex].getAttribute('data-rate');

                        let rateInput = document.querySelector(`input[name="items[${index}][rate]"]`);
                        let hiddenRateInput = document.querySelector(
                            `input[name="items[${index}][rate_hidden]"]`);

                        rateInput.value = rate;
                        hiddenRateInput.value = rate;
                    });
                });
            });
        </script>
    @endsection
