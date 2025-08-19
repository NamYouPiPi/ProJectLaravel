<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->

        <div class="col-md-6">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            @if($movies->isEmpty())
                <div class="alert alert-warning">No movies available. Please add a movie first.</div>
            @else
                <select name="movie_id" id="title" class="form-select" required>
                    <option value="">Select Movie</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}" {{ old('movie_id', $showtime->movie_id ?? '') === $movie->id ? ' selected' : '' }}>
                            {{ $movie->title }}
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="col-md-6">
            <label for="hall_id" class="form-label">Hall Name <span class="text-danger">*</span></label>
            <select name="hall_id" id="hall_id" class="form-select" required>
                <option value="">Select Hall</option>
                @foreach($hallCinema as $hall)
                    <option value="{{ $hall->id }}" {{ old('hall_id', $showtime->hall_id ?? '') === $hall->id ? ' selected' : '' }}>
                        {{ $hall->cinema_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="start_time"
                value="{{ old('start_time', $showtime->start_time ?? '') }}" id="start_time" required />
        </div>
        <div class="col-md-6">
            <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
            <input type="date" class="form-control" name="end_time"
                value="{{ old('end_time', $showtime->end_time ?? '') }}" id="end_time" required />
        </div>

    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label for="base_price" class="form-label">Base Price <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="base_price"
                value="{{ old('base_price', $showtime->base_price ?? '') }}" id="base_price" required />
        </div>
        <div class="col-md-6">
            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-select" required>
                <option value="">Select Status</option>
                <option value="upcoming" {{old('status', $showtime->status ?? '') === 'upcoming' ? ' selected' : ''}}>
                    Upcoming
                </option>
                <option value="ongoing" {{old('status', $showtime->status ?? '') === 'ongoing' ? ' selected' : ''}}>
                    Ongoing</option>
                <option value="ended" {{old('status', $showtime->status ?? '') === 'ended' ? ' selected' : ''}}>
                    Ended</option>
            </select>
        </div>

    </div>


</div>
<!--end::Body-->
<!--begin::Footer-->
<div class="card-footer mt-2">
    <button class="btn btn-info float-start" type="submit">


        {{ isset($showtime) ? 'Update' : 'Save' }}

    </button>
    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Cancel</button>
</div>
