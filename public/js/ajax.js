// Show alert function
function confirmDelete(id, base_url) {
    Swal.fire({
        title: "Are you sure?",
        text: "This will permanently delete the " + base_url,
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

                // Show success message with SweetAlert
                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: "The record has been updated successfully.",
                    timer: 1500,
                    showConfirmButton: false,
                });

                // Reload page after SweetAlert closes
                setTimeout(() => location.reload(), 500);
            },
            error: function (xhr) {
                form.find('button[type="submit"]')
                    .prop("disabled", false)
                    .text("Update");

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    displayValidationErrors(form, errors);
                } else {
                    console.error("Update error:", xhr);
                }
            },
        });
    });
}

function showDetails(id, type) {
    $.ajax({
        url: `/${type}/${id}`,
        type: "GET",
        success: function (response) {
            // Populate the modal with movie details
            $("#detailsModal .modal-body").html(response);
            $("#detailsModal").modal("show");
        },
        error: function (xhr) {
            $("#detailsModal .modal-body").html(
                '<div class="alert alert-danger">Error loading details. Please try again.</div>'
            );
            console.error("Error loading details:", xhr);
        },
    });
}
