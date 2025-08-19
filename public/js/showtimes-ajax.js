$(function() {
    // click “Edit” → turn row into inputs
    $(document).on('click', '.btn-edit-ajax', function() {
        let row = $(this).closest('tr');
        row.find('.editable').each(function() {
            let txt = $(this).text().trim();
            let fld = $(this).data('field');
            let type = (fld.includes('date')||fld.includes('time')) ? 'date' : (fld=='base_price' ? 'number' : 'text');
            $(this).html(`<input type="${type}" class="form-control form-control-sm" name="${fld}" value="${txt}">`);
        });
        row.find('.btn-edit-ajax').hide();
        row.find('.btn-save-ajax, .btn-cancel-ajax').show();
    });

    // click “Cancel” → reload page (or you could cache original values and restore)
    $(document).on('click', '.btn-cancel-ajax', function() {
        location.reload();
    });

    // click “Save” → collect inputs & send AJAX
    $(document).on('click', '.btn-save-ajax', function() {
        let row = $(this).closest('tr');
        let id  = row.data('id');
        let payload = { _token: $('meta[name="csrf-token"]').attr('content') };
        row.find('input[name]').each(function() {
            payload[$(this).attr('name')] = $(this).val();
        });

        $.ajax({
            url: `/showtimes/${id}/ajax-update`,
            type: 'PUT',
            data: payload,
            success: function(res) {
                if (res.success) {
                    // replace inputs with new text
                    row.find('.editable').each(function() {
                        let fld = $(this).data('field');
                        $(this).text(res.data[fld]);
                    });
                    row.find('.btn-save-ajax, .btn-cancel-ajax').hide();
                    row.find('.btn-edit-ajax').show();
                    showAlert('Showtime updated', 'success');
                }
            },
            error: function() {
                showAlert('Update failed', 'danger');
            }
        });
    });
});
