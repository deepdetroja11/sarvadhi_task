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
                                                    <option value="{{ $item->id }}" data-rate="{{ $item->rate }}">
                                                        {{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control quantity-input"
                                                name="items[0][quantity]" placeholder="Quantity" />
                                            @error('quantity')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control rate-input" name="items[0][rate]"
                                                placeholder="Rate" readonly />
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
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                let itemIndex = 1;

                document.getElementById('addItem').addEventListener('click', function() {
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-2');
                    newRow.innerHTML = `
            <div class="col-md-4">
                <select class="form-control item-select" name="items[${itemIndex}][item_id]" data-index="${itemIndex}">
                    <option value="" data-rate="">Select Item</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" data-rate="{{ $item->rate }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" placeholder="Quantity"/>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control rate-input" name="items[${itemIndex}][rate]" placeholder="Rate" readonly />
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" name="items[${itemIndex}][total]" placeholder="Total" readonly />
            </div>
            <div class="col-md-2 d-flex">
                <button type="button" class="btn btn-danger remove-item mr-2">Remove</button>
                <button type="button" class="btn btn-primary add-item">Add Item</button>
            </div>
        `;
                    document.getElementById('itemsContainer').appendChild(newRow);
                    itemIndex++;
                });

                document.getElementById('itemsContainer').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-item')) {
                        e.target.closest('.row').remove();
                    }
                });

                document.getElementById('itemsContainer').addEventListener('change', function(e) {
                    if (e.target.classList.contains('item-select')) {
                        const index = e.target.getAttribute('data-index');
                        const selectedOption = e.target.options[e.target.selectedIndex];
                        const rate = selectedOption.getAttribute('data-rate');
                        document.querySelector(`input[name="items[${index}][rate]"]`).value = rate;
                    }
                });
            });
        </script> --}}



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('itemsContainer').addEventListener('change', function(e) {
                    if (e.target.classList.contains('item-select')) {
                        const index = e.target.getAttribute('data-index');
                        const selectedOption = e.target.options[e.target.selectedIndex];
                        const rate = selectedOption.getAttribute('data-rate');
                        document.querySelector(`input[name="items[${index}][rate]"]`).value = rate;
                    }
                });
                document.getElementById('itemsContainer').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-item')) {
                        e.target.closest('.row').remove();
                    }
                });
            });
        </script>
    @endsection
