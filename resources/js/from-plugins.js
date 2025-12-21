import $ from 'jquery';
import "./jquery.validate.js";
$(document).ready(function () {
    $(".jquery_form_validation").validate({
        errorPlacement: function (error, element) {
            if (element.hasClass("select2-hidden-accessible")) {
                // Find the `select2` container
                var select2Container = element.next(".select2-container");
                // Insert the error message after the `select2` container
                error.insertAfter(select2Container);
            } else if (element.is(":radio")) {
                // For checkboxes, place the error message after the label
                error.insertAfter(element.closest("label"));
            } else if (element.is(":checkbox")) {
                // For checkboxes, place the error message on the next line
                error.insertAfter(element.parent().parent()); // Adjust based on your checkbox structure
            } else {
                // Default placement: insert after the form element
                error.insertAfter(element);
            }
        },
        // Highlight and unhighlight functions to add error class to the `select2` container
        highlight: function (element, errorClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next(".select2-container").addClass(errorClass);
            } else {
                $(element).addClass(errorClass);
            }
        },
        unhighlight: function (element, errorClass) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element).next(".select2-container").removeClass(errorClass);
            } else {
                $(element).removeClass(errorClass);
            }
        },
    });

    $("form .file_validation").on("change", function () {
        $(this).valid();
    });

    $("form .image_dimension_validation").on("change", function () {
        $(this).valid();
    });
});
