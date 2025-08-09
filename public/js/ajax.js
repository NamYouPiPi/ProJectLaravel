


// Show alert function
function showAlert(message, type = "success") {
    const alertHtml = `
              <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                  ${message}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
                                        `;
    $("#alert-container").html(alertHtml);

    // Auto hide after 3 seconds
    setTimeout(() => {
        $(".alert").alert("close");
    }, 3000);
}

// ================ Button Edit ========================
let currentSupplierId   = null;
function  EditById(btnEdit ,Base_url ){
    btnEdit.on("click", function () {
        let id = $(this).data("id");
        currentSupplierId = id;
        console.log(currentSupplierId);
        // Show loading spinner
        $("#updateModal .modal-body").html(`<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>`);

        // Show modal first
        $("#updateModal").modal("show");

        // Load edit form via AJAX
        $.ajax({
            url: `/${Base_url}/` + id + "/edit",
            type: "GET",
            success: function (response) {
                $("#updateModal .modal-body").html(response);
            },
            error: function (xhr) {
                $("#updateModal .modal-body").html(
                    '<div class="alert alert-danger">Error loading supplier data. Please try again.</div>'
                );
                console.error("Error loading edit form:", xhr);
            },
        });
    });
// =========== update submit ===================
    $(document).on("submit", "#updateForm", function (e) {
        e.preventDefault();
        let form = $(this);
        let id = form.find('[name="id"]').val() || currentSupplierId;
        form.find('button[type="submit"]')
            .prop("disabled", true)
            .text("Updating...");

        $.ajax({
            url: `/${Base_url}/` + id,
            type: "POST",
            data: form.serialize() + "&_method=PUT",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log("Update response:", response);
                $("#updateModal").modal("hide");
                showAlert("Supplier updated successfully!", "success");

                // Update the table row with new data
                if (response.Base_url) {
                    updateTableRow(response.Base_url);
                } else {
                    setTimeout(() => location.reload(), 1000);
                }
            },
            //  ============= handle error ===================
            error: function (xhr) {
                form.find('button[type="submit"]')
                    .prop("disabled", false)
                    .text("Update Supplier");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    displayValidationErrors(form, errors);
                } else {
                    showAlert(
                        "Error updating supplier. Please try again.",
                        "danger"
                    );
                    console.error("Update error:", xhr);
                }
            },
        });
//     =============== end of submit button ===================
    });

}
// ================== begin  handle  delete ===================
function DeleteById(btnDelete  , base_url , Base_TableRow){
    let currentId;
    btnDelete.on("click", function () {
        currentId = $(this).data("id");
        console.log(currentId);
        $('#deleteModal').modal("show");
    });
    $('#confirmDeleteBtn').on("click", function () {
        if (currentId) {
            $.ajax({
                url: `/${base_url}/` + currentId,
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#deletemodal').modal("hide"); // Match the ID from blade file
                    showAlert("Data deleted successfully!", "success");
                    $('#cancel').click();
                    $(Base_TableRow + currentId).fadeOut(function() { // Use fadeOut instead of fadeIn
                        $(this).remove();
                    });
                },

                error: function (xhr) {
                    $('#deleteModal').modal("hide");
                    $(this).remove();
                    showAlert(
                        "Error deleting supplier. Please try again.",
                        "danger"
                    );
                    console.log(xhr)
                    // console.error("Delete error:", xhr)
                },
            });
        }
    });
}

// ================ end of handle delete ======================
function updateTableRow(supplier) {
    let row = $("#supplier-row" + supplier.id);
    if (row.length) {
        row.find(".supplier-name").text(supplier.name);
        row.find(".supplier-email").text(supplier.email);
        row.find(".supplier-phone").text(supplier.phone);
        row.find(".supplier-contact").text(supplier.contact_person);
        row.find(".supplier-type").text(supplier.supplier_type);
        row.find(".supplier-status").text(supplier.status);
        row.find(".supplier-address").text(supplier.address);
        row.find(".supplier-updated").text(
            new Date().toLocaleDateString("en-CA")
        );
        // Add a highlight effect
        row.addClass("table-success");
        setTimeout(() => {
            row.removeClass("table-success");
        }, 2000);
    }
}
// Function to display validation errors
function displayValidationErrors(form, errors) {
    // Clear previous errors
    form.find(".is-invalid").removeClass("is-invalid");
    form.find(".invalid-feedback").remove();
    form.find(".alert-danger").remove();
    // Display errors
    let errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
    $.each(errors, function (field, messages) {
        // Add error to input field
        let input = form.find('[name="' + field + '"]');
        input.addClass("is-invalid");

        // Add error message after input
        input.after('<div class="invalid-feedback">' + messages[0] + "</div>");

        // Add to general error list
        errorHtml += "<li>" + messages[0] + "</li>";
    });
    errorHtml += "</ul></div>";

    // Add general error list at top of form
    form.prepend(errorHtml);
}

// Clear form validation when modal is hidden
$("#updateModal").on("hidden.bs.modal", function () {
    $(this).find(".is-invalid").removeClass("is-invalid");
    $(this).find(".invalid-feedback").remove();
    $(this).find(".alert").remove();
});
// module.exports ={DeleteById}
