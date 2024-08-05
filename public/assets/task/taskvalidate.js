$(document).ready(function() {
    $('#taskForm').validate({
        rules: {
            title: {
                required: true,
            },
            description: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "Please Enter titie",
            },
            description: {
                required: "Please Enter description",
            },
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
});
