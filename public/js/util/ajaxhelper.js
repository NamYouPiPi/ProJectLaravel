function ajaxUpdate(btn, baseUrl) {
    btn.on("click", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let form = $("#updateForm" + id)[0]; // dynamic form per row/modal
        let formData = new FormData(form);

        $.ajax({
            url: "/" + baseUrl + "/" + id,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (res) {
                if (res.status) {
                    alert(res.message);
                    location.reload(); // reload or update table dynamically
                } else {
                    alert("Update failed!");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Error occurred while updating!");
            },
        });
    });
}
