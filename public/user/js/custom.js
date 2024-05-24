$(document).ready(function () {
    $("#userLoginForm").validate({
        rules: {
            email: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
        },
        messages: {
            email: {
                required: "Email is required",
            },
            password: {
                required: "Password is required ",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });
});
