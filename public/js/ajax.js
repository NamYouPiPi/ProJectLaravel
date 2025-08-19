// Show alert function
function confirmDelete(id, base_url) {
    Swal.fire({
        title: "Are you sure?",
        text: "This will permanently delete the seat type.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it",
    }).then((result) => {
        if (result.isConfirmed) {
            // Get the CSRF token from meta tag
            let csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");

            // Create a form with the correct action and method
            let form = document.createElement("form");
            form.action = `/${base_url}/${id}`;
            form.method = "POST";
            form.style.display = "none"; // Hide the form

            // Add CSRF token
            let tokenInput = document.createElement("input");
            tokenInput.type = "hidden";
            tokenInput.name = "_token";
            tokenInput.value = csrfToken;
            form.appendChild(tokenInput);

            // Add method spoofing for DELETE
            let methodInput = document.createElement("input");
            methodInput.type = "hidden";
            methodInput.name = "_method";
            methodInput.value = "DELETE";
            form.appendChild(methodInput);

            // Add form to body and submit
            document.body.appendChild(form);
            form.submit();
        }
    });
}






// -------- alert =------------





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
let currentId = null;

function EditById(btnEdit, Base_url) {
    btnEdit.on("click", function () {
        let id = $(this).data("id");
        currentId = id;
        console.log(currentId);
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
        let id = form.find('[name="id"]').val() || currentId;
        console.log(id);
        form.find('button[type="submit"]')
            .prop("disabled", true)
            .text("Updating...");

        // Use FormData for file uploads
        let formData = new FormData(this);
        formData.append("_method", "PUT");

        $.ajax({
            url: `/${Base_url}/` + id,
            type: "POST",
            data: formData,
            processData: false, // Important for FormData
            contentType: false, // Important for FormData
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
                    showAlert(
                        "Error updating data. Please try again.",
                        "danger"
                    );
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
        $("#deletemodal").modal("show");
    });

    $("#confirmDeleteBtn").on("click", function () {
        if (currentId) {
            // Close modal immediately using jQuery (works for both Bootstrap 4 & 5)
            $("#deletemodal").modal("hide");

            // Add a small delay to ensure modal is fully closed
            setTimeout(() => {
                $.ajax({
                    url: `/${base_url}/` + currentId,
                    type: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        // if (callback) callback();
                        showAlert(
                            "Data was changed status to inactive successfully!",
                            "success"
                        );
                        location.reload();
                    },
                    error: function (xhr) {
                        showAlert(
                            "Error deleting data. Please try again.",
                            "danger"
                        );
                        console.log(xhr);
                    },
                });
            }, 300); // Small delay to ensure modal closes properly
        }
    });
}

//     function DeleteById(btnDelete, base_url) {
//         let currentId;

//         btnDelete.on("click", function () {
//         currentId = $(this).data("id");
//         console.log(currentId);
//         $("#deletemodal").modal("show");
//     });

//     $("#confirmDeleteBtn").on("click", function () {
//         if (currentId) {
//             // Close modal immediately
//             $("#deletemodal").modal("hide");

//             $.ajax({
//                 url: `/${base_url}/` + currentId,
//                 type: "DELETE",
//                 headers: {
//                     "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
//                         "content"
//                     ),
//                 },
//                 success: function (response) {
//                     showAlert(
//                         "Data was change status to inactive successfully!",
//                         "success"
//                     );
//                     setTimeout(function () {
//                         location.reload();
//                     }, 1500);
//                 },
//                 error: function (xhr) {
//                     showAlert(
//                         "Error deleting data. Please try again.",
//                         "danger"
//                     );
//                     console.log(xhr);
//                 },
//             });
//         }
//     });
// }
// function DeleteById(btnDelete, base_url) {
//     let currentId;

//     btnDelete.on("click", function () {
//         currentId = $(this).data("id");
//         console.log(currentId);
//         $('#deletemodal').modal("show");
//     });
//     $('#confirmDeleteBtn').on("click", function () {
//         if (currentId) {
//             $.ajax({
//                 url: `/${base_url}/` + currentId,
//                 type: "DELETE",
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },

//                 success: function(response) {
//                     $('#deletemodal').modal("hide"); // Close modal
//                     showAlert("Data was change status to inacitve  successfully!", "success");

//                     // Optional: delay before refresh to show toast
//                     setTimeout(function () {
//                         location.reload(); // Refresh page
//                     }, 1500); // 1.5 seconds delay
//                 },

//                 error: function (xhr) {
//                     $('#deletemodal').modal("hide");
//                     showAlert("Error deleting data. Please try again.", "danger");
//                     console.log(xhr);
//                 }
//             });
//         }
//     });}
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
