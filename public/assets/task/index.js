$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#taskData").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "desc"]],
        ajax: window.taskRoutes.index,
        ajax: {
            url: window.taskRoutes.index,
            data: function (d) {
                d.status = $('#userSelect').val();
                d.invoice_date = $('#invoiceDate').val();
            }
        },

        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex", searchable: false },
            { data: "customer_name", name: "customer_name" },
            { data: "invoice_date", name: "invoice_date" },
            { data: "due_date", name: "due_date" },
            { data: "tax", name: "tax" },
            { data: "total", name: "total" },
            {
                data: "status",
                name: "status",
                render: function(data, type, row) {
                    var statusClass = data === 1 ? 'badge-success' : 'badge-danger';
                    var statusText = data === 1 ? 'Paid' : 'Unpaid';
                    return `<span class="badge ${statusClass}">${statusText}</span>`;
                }
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    $('#userSelect, #invoiceDate').change(function() {
        table.draw();
    })


    var flashMessage = $("#flash-message");

    if (flashMessage.length) {
        flashMessage.show();

        setTimeout(function () {
            flashMessage.fadeOut("slow");
        }, 3000);
    }
});

function deleteInvoice(invoiceId) {
    if (confirm("Are you sure you want to delete this Invoice?")) {
        $.ajax({
            type: "DELETE",
            url: window.taskRoutes.destroy.replace(":id", invoiceId),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    $("#taskData").DataTable().ajax.reload();
                } else {
                    alert("Failed to delete task. Please try again.");
                }
            },
            error: function (xhr, status, error) {
                alert("Failed to delete task: " + error);
            },
        });
    }
}

$(document).ready(function() {
    $("#invoiceDate").datepicker({
        dateFormat: "yy-mm-dd"
    });
});

