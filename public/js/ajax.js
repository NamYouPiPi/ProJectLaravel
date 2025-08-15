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
let currentSupplierId = null;


function EditById(btnEdit, Base_url) {
    btnEdit.on("click", function () {
        let id = $(this).data("id");
        currentSupplierId = id;
        console.log(currentSupplierId);

        // Update modal title based on the data type
        let modalTitle = "Edit " + Base_url.charAt(0).toUpperCase() + Base_url.slice(1);
        $("#updateModalLabel").text(modalTitle);

        // Show loading spinner
        $("#updateModal .modal-body").html(`
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);

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
                    '<div class="alert alert-danger">Error loading data. Please try again.</div>'
                );
                console.error("Error loading edit form:", xhr);
            },
        });
    });
$(document).on("submit", "#updateForm", function (e) {
    e.preventDefault();
    let form = $(this);
    let id = form.find('[name="id"]').val() || currentSupplierId;

    form.find('button[type="submit"]')
        .prop("disabled", true)
        .text("Updating...");

    // Use FormData for file uploads
    let formData = new FormData(this);
    formData.append('_method', 'PUT');

    $.ajax({
        url: `/${Base_url}/` + id,
        type: "POST",
        data: formData,
        processData: false,      // Important for FormData
        contentType: false,      // Important for FormData
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log("Update response:", response);
            $("#updateModal").modal("hide");
            showAlert("Data updated successfully!", "success");
            setTimeout(() => location.reload(), 1000);
        },
        error: function (xhr) {
            form.find('button[type="submit"]')
                .prop("disabled", false)
                .text("Update");

            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                displayValidationErrors(form, errors);
            } else {
                showAlert("Error updating data. Please try again.", "danger");
                console.error("Update error:", xhr);
            }
        },
    });
});

}

// // ================== begin  handle  delete ===================

function DeleteById(btnDelete, base_url) {
    let currentId;

    btnDelete.on("click", function () {
        currentId = $(this).data("id");
        console.log(currentId);
        $('#deletemodal').modal("show");
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
                    $('#deletemodal').modal("hide"); // Close modal
                    showAlert("Data was change status to inacitve  successfully!", "success");


                    // Optional: delay before refresh to show toast
                    setTimeout(function () {
                        location.reload(); // Refresh page
                    }, 1500); // 1.5 seconds delay
                },

                error: function (xhr) {
                    $('#deletemodal').modal("hide");
                    showAlert("Error deleting data. Please try again.", "danger");
                    console.log(xhr);
                }
            });
        }
    });}
// ================ end of handle delete ======================

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
