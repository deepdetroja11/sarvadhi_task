<!DOCTYPE html>
<html>
<head>
    <title>Invoice PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .table-container {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div>
        <h1>Invoice #{{ $invoice->id }}</h1>
        <p>Customer Name: {{ $invoice->customer_name }}</p>
        <p>Invoice Date: {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</p>
        <p>Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}</p>
        <p>Tax (%): {{ $invoice->tax }}</p>

        <h2>Items</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->rate }}</td>
                            <td>{{ $item->quantity * $item->rate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h3>Total: {{ $invoice->total }}</h3>
    </div>
</body>
</html>
