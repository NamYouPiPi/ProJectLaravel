@props(['dataTable'=>'default' , 'title'=>'Delete Record'])
<div {{ $attributes }}>
    {{ $slot }}
</div>
{{--            --}}{{-- --------------- delete modal -------------------}}
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  id=cancel" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>
{{--            --}}{{-- --------------- end of delete modal -------------}}
