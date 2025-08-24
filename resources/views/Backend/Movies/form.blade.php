<div class="card-body">
        {{-- Title --}}
        {{-- <input type="hidden" name="id" value="{{ $movie->id ?? '' }}"> --}}
        <div class="row g-3">
            <div class="col-md-6">
                <label for="title" class="form-label float-start">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="title"
                    value="{{ old('title', $movie->title ?? '') }}" required>
            </div>

            {{-- Duration --}}
            <div class="col-md-6">
                <label for="duration_minutes" class="form-label float-start">Duration (min) <span
                        class="text-danger">*</span></label>
                <input type="number" class="form-control" name="duration_minutes" id="duration_minutes"
                    value="{{ old('duration_minutes', $movie->duration_minutes ?? '') }}" required>
            </div>
        </div>

        {{-- Director & Description --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="director" class="form-label float-start">Director <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="director" id="director"
                    value="{{ old('director', $movie->director ?? '') }}" required>
            </div>

            <div class="col-md-6">
                <label for="language" class="form-label float-start">Language <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="language" id="language"
                    value="{{ old('language', $movie->language ?? '') }}" required>
            </div>

        </div>

        {{-- Language & Status --}}
         <div class="row g-3 mt-2">

            <div class="col-md-6">
                <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
                <select class="form-select" name="status" id="status" required>
                    <option value="">Please select status</option>
                    <option value="active" {{ old('status', $movie->status ?? '') == 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="inactive" {{ old('status', $movie->status ?? '') == 'inactive' ? 'selected' : '' }}>
                        Inactive</option>
                </select>
            </div>
        <div class="col-md-6">
                    <label for="genre_id" class="form-label float-start">Genre</label>
                    <select class="form-select" name="genre_id" id="genre_id" required>
                        <option value="">Select Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id', $movie->genre_id ?? '') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->main_genre }} {{-- or $genre->main_genre if that's your column --}}
                            </option>
                        @endforeach
                    </select>

                </div>
        </div>


        {{-- Supplier & Classification --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="supplier_id" class="form-label float-start">Supplier <span class="text-danger">*</span></label>
                <select class="form-select" name="supplier_id" id="supplier_id" required>
                    <option value="">Please select supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $movie->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="classification_id" class="form-label float-start">Classification <span class="text-danger">*</span></label>
                @if($classifications->isEmpty())
                    <div class="alert alert-warning">No classifications available. Please add a classification first.</div>
                @else
                    <select class="form-select" name="classification_id" id="classification_id" required>
                        <option value="">Select Classification</option>
                        @foreach($classifications as $classification)
                            <option value="{{ $classification->id }}" {{ old('classification_id', $movie->classification_id ?? '') == $classification->id ? 'selected' : '' }}>
                                {{ $classification->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        {{-- Poster & Trailer --}}
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="poster" class="form-label float-start">Poster</label>
                <input type="file" class="form-control" name="poster" id="poster" accept="image/*">
                @if(isset($movie) && $movie->poster)
                    <img src="{{ asset('storage/' . $movie->poster) }}" alt="Poster" class="img-thumbnail mt-2"
                        width="100">
                @endif
            </div>

            <div class="col-md-6">
                <label for="trailer" class="form-label float-start">Trailer</label>
                <input type="url" class="form-control" name="trailer" id="trailer" placeholder="Enter video URL" value="{{ old('trailer', isset($movie->trailer) ? $movie->trailer : '') }}">
                <iframe width="40px" height="40px" src="{{ old('trailer', isset($movie->trailer) ? $movie->trailer : '') }}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="row g-3 mt-2">
               <div class="col-md-6">
                <label for="release_date" class="form-label float-start">Release Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="release_date" id="release_date"
                    value="{{ old('release_date', isset($movie->release_date) ? $movie->release_date : '') }}"
                    required>
            </div>
            <div class="col-md-12">
                <label for="description" class="form-label float-start">Description</label>
                <textarea class="form-control" name="description" id="description" rows="2">{{ old('description', $movie->description ?? '') }}</textarea>
            </div>



    </div>

    {{-- Form Buttons --}}
    <div class="card-footer mt-3">
        <button class="btn btn-info" type="submit">{{ isset($movie) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('movies.index') }}" class="btn btn-secondary float-end">Cancel</a>
    </div>
