<form action="{{ isset($promotion) ? route('promotions.update', $promotion) : route('promotions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($promotion))
        @method('PUT')
    @endif
    <div class="mb-3">
  <label for="title" class="form-label">Title</label>
  <input class="form-control" id="title" name="title" rows="3">{{ isset($promotion) ? $promotion->title : '' }}</input>
</div>
    <div class="mb-3">
  <label for="image" class="form-label">Image</label>
  <input type="file" value="{{ isset($promotion) ? asset($promotion->proImage) : '' }}" class="form-control" id="image" name="proImage" accept="image/*">
</div>
<div class="mb-3">
  <label for="description" class="form-label">Description</label>
  <textarea class="form-control" id="description" name="description" rows="3">{{ isset($promotion) ? $promotion->description : '' }}</textarea>
</div>







    <div class="mt-4">
        <button class="btn btn-primary" type="submit">
            {{ isset($promotion) ? 'Update' : 'Save' }} Promotion
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
