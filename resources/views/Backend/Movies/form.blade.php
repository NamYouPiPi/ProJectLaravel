<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="title" class="form-label float-start">Title <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('title',$movies->title ?? '') }}"
                   class="form-control" name="title" id="title" required />
        </div>

        <div class="col-md-6">
            <label for="duration_minutes" class="form-label float-start">Duration (min) <span class="text-danger">*</span></label>
             <input type="number" class="form-control"
                    name="duration_minutes"
                    id="duration_minutes" required />
        </div>
    </div>

    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="director" class="form-label float-start">Director <span class="text-danger">*</span></label>
           <input type="text" value="{{ old('director',$movies->director ?? '') }}"
                  class="form-control"
                  name="director"
                  id="director" required>
        </div>
        <div class="col-md-6">
            <label for="description" class="form-label float-start">Description <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('description',$movies->description ?? '') }}"
                   class="form-control"
                   id="description"
                   name="description"
                   required />
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="language" class="form-label float-start">languages <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('language',$movies->language ?? '') }}"
                   class="form-control"
                   name="language"
                   id="language" />
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label float-start">Status <span class="text-danger">*</span></label>
            <select class="form-select" name="status" aria-label="Please select status">
                <option value="">Please select status</option>
                <option value="active" {{ (old('status', $movies->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status', $movies->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>


    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="release_date" class="form-label float-start">Release Date <span class="text-danger">*</span></label>
            <input type="date"
                   value="{{ old('release_date',$movies->release_date ?? '') }}"
                   class="form-control"
                   name="release_date"
                   id="validationCustom01" />
        </div>
        <div class="col-md-6">
            <label for="genre_id" class="form-label float-start">Genre <span class="text-danger">*</span></label>
            <input type="text"
                   value="{{ old('genre_id'
                    ,$movies->genre_id ?? '') }}"
                   class="form-control"
                   name="genre_id"
                   id="genre_id" />
            {{--
     <select class="form-select" name="genre_id" >--}}
{{--                <option value="">Please select genre</option>--}}
{{--                @foreach($genres as $genre)--}}
{{--                    <option value="{{ $genre->genre_id }}"--}}
{{--                        {{ old('genre_id') == $genre->genre_id ? 'selected' : '' }}>--}}
{{--                        {{ $genre->main_genre }}--}}
{{--                    </option>--}}
{{--               <option value="{{old('genre_id', $genre->genre_id ?? '') == $genre->genre_id ? 'selected' : ''}}">{{ $genre->main_genre}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
        </div>
    </div>



    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="supplier_id" class="form-label float-start">Supplier Name<span class="text-danger">*</span></label>
                <input type="text"
                       value="{{ old('supplier_id',$movies->supplier_id ?? '') }}"
                       class="form-control" name="supplier_id" id="validationCustom01" />
{{--            <input type="number" value="{{ old('releas_date',$movies->releas_date ?? '') }}" class="form-control" name="releas_date" id="validationCustom01" />--}}
        </div>
        <div class="col-md-6">
            <label for="classification_id" class="form-label float-start">Classifications  <span class="text-danger">*</span></label>
            <input type="text"
                   name="classification_id"
                   value="{{ old('classification_id',$movies->classification_id ?? '') }}"
                   class="form-control"  id="validationCustom02" />
{{--             <input type="text" value="{{ old('genre_id',$movies->genre_id ?? '') }}" class="form-control" name="genre_id" id="validationCustom02" />--}}
{{--            <select class="form-select" name="genre_id" >--}}
{{--                <option value="">Please select genre</option>--}}
{{--                @foreach($genres as $genre)--}}
{{--                    <option value="{{ $genre->genre_id }}"--}}
{{--                        {{ old('genre_id') == $genre->genre_id ? 'selected' : '' }}>--}}
{{--                        {{ $genre->main_genre }}--}}
{{--                    </option>--}}
{{--               <option value="{{old('genre_id', $genre->genre_id ?? '') == $genre->genre_id ? 'selected' : ''}}">{{ $genre->main_genre}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
        </div>
    </div>
    <div class="row g-3">
        <!--begin::Col-->
        <div class="col-md-6">
            <label for="poster" class="form-label float-start">Poster url</label>
            <input type="file" value="{{ old('poster',$movies->poster ?? '') }}"
                   class="form-control"
                   name="poster"  id="poster_url" />
        </div>

        <div class="col-md-6">
            <label for="trailer" class="form-label float-start">Trailer Url </label>
            <input type="file" class="form-control"
                   id="trailer" name="trailer"
                   accept="video/*" >
        </div>
    </div>
</div>

{{---------------- start cart footer ----------------------}}
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">{{ isset($movies) ? 'Update' : 'Save' }}</button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>

{{---------------- end cart footer ----------------------}}
