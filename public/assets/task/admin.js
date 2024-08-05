$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#taskData").DataTable({
        processing: true,
        serverSide: true,
        order: [
            [0, "desc"]
        ],
        ajax: window.taskRoutes.index,
        ajax: {
            url: window.taskRoutes.index,
            data: function (d) {
                d.user_id = $('#userSelect').val();
                d.invoice_date = $('#invoiceDate').val();
            }
        },
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                searchable: false
            },
            {
                data: "customer_name",
                name: "customer_name"
            },
            {
                data: "invoice_date",
                name: "invoice_date"
            },
            {
                data: "due_date",
                name: "due_date"
            },
            {
                data: "tax",
                name: "tax"
            },
            {
                data: "total",
                name: "total"
            },
        ],
    });

    $('#userSelect, #invoiceDate').change(function() {
        table.draw();
    })


});

$(document).ready(function() {
    $("#invoiceDate").datepicker({
        dateFormat: "yy-mm-dd"
    });
});
