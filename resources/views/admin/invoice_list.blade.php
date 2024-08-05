@extends('layout.app')
@section('body')

@section('style')
    <link href="{{ asset('assets') }}/plugins/datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    @endsection
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Invoice<span class="font-weight-normal text-muted ml-2">Information</span></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="userSelect">Select User</label>
            <select id="userSelect" class="form-control">
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="invoiceDate">Invoice Date</label>
            <input type="text" id="invoiceDate" class="form-control" placeholder="Select Date">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div id="table-wrapper">
                    <div id="table-scroll">
                        <table class="table table-vcenter text-nowrap table-bordered border-bottom" id="taskData">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets') }}/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/js/dataTables.bootstrap4.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets') }}/plugins/datatable/responsive.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets') }}/task/admin.js"></script>

<script>
    window.taskRoutes = {
        index: "{{ route('user.invoice') }}",
    };
</script>
@endsection
