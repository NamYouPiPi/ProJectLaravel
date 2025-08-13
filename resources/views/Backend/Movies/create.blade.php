<form method="POST" action="{{ isset($movies) ? route('movies.update', $movies->id) : route('movies.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if(isset($movies))
        @method('PUT')
    @endif

    <div class="card-body">
        {{-- Title --}}
        <div class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="title"
                    value="{{ old('title', $movies->title ?? '') }}" required>
            </div>

            {{-- Duration --}}
            <div class="col-md-6">
                <label for="duration_minutes" class="form-label">Duration (min) <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" name="duration_minutes" id="duration_minutes"
                    value="{{ old('duration_minutes', $movies->duration_minutes ?? '') }}" required>
            </div>
        </div>

        {{-- Director & Description --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="director" class="form-label">Director <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="director" id="director"
                    value="{{ old('director', $movies->director ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" name="description" id="description" rows="3"
                    required>{{ old('description', $movies->description ?? '') }}</textarea>
            </div>
        </div>

        {{-- Language & Status --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="language" id="language"
                    value="{{ old('language', $movies->language ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status" id="status" required>
                    <option value="">Please select status</option>
                    <option value="active" {{ old('status', $movies->status ?? '') == 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="inactive" {{ old('status', $movies->status ?? '') == 'inactive' ? 'selected' : '' }}>
                        Inactive</option>
                </select>
            </div>
        </div>

        {{-- Release Date & Genre --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="release_date" class="form-label">Release Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="release_date" id="release_date"
                    value="{{ old('release_date', isset($movies->release_date) ? ($movies->release_date)->format('Y-m-d') : '') }}"
                    required>
            </div>

            <div class="col-md-6">
                <label for="genre_id">Genre</label>
                <select class="form-select" name="genre_id" id="genre_id" required>
                    <option value="">Select Genre</option>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>
                            {{ $genre->name }} {{-- Make sure this matches your genre column name --}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Supplier & Classification --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="supplier_id" class="form-label">Supplier <span class="text-danger">*</span></label>
                <select class="form-select" name="supplier_id" id="supplier_id" required>
                    <option value="">Please select supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $movies->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="classification_id" class="form-label">Classification <span
                        class="text-danger">*</span></label>
                <select class="form-select" name="classification_id" id="classification_id" required>
                    <option value="">Select Classification</option>
                    @foreach($classifications as $classification)
                        <option value="{{ $classification->id }}" {{ old('classification_id') == $classification->id ? 'selected' : '' }}>
                            {{ $classification->name }} {{-- Make sure this matches your classification column name --}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Poster & Trailer --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="poster" class="form-label">Poster</label>
                <input type="file" class="form-control" name="poster" id="poster" accept="image/*">
                @if(isset($movies) && $movies->poster)
                    <img src="{{ asset('storage/' . $movies->poster) }}" alt="Poster" class="img-thumbnail mt-2"
                        width="100">
                @endif
            </div>

            <div class="col-md-6">
                <label for="trailer" class="form-label">Trailer</label>
                <input type="file" class="form-control" name="trailer" id="trailer" accept="video/*">
                @if(isset($movies) && $movies->trailer)
                    <video class="mt-2" width="200" controls>
                        <source src="{{ asset('storage/' . $movies->trailer) }}" type="video">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        </div>
    </div>

    {{-- Form Buttons --}}
    <div class="card-footer mt-3">
        <button class="btn btn-info" type="submit">{{ isset($movies) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary float-end">Cancel</a>
    </div>
</form>