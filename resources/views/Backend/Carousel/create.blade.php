<form action="{{ isset($carousel) ? route('carousels.update', $carousel) : route('carousels.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($carousel))
        @method('PUT')
    @endif

    <div class="mb-3">
  <label for="image" class="form-label">Carousel Image</label>
  <input type="file" value="{{ isset($carousel) ? asset($carousel->carouselImage) : '' }}" class="form-control" id="image" name="carouselImage" accept="image/*">
</div>

    <div class="mt-4">
        <button class="btn btn-primary" type="submit">
            {{ isset($carousel) ? 'Update' : 'Save' }} Carousel
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
    </div>
</form>
