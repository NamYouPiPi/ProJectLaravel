<!--begin::Body-->
<div class="card-body">
    <!--begin::Row-->
    <div class="row g-3">
        <!--begin::Col-->

            <div class="col-md-6">
            <label for="movie_id" class="form-label">Movie <span class="text-danger">*</span></label>
            <select class="form-select" id="movie_id" name="movie_id" required>
                <option value="">Select Movie</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}"
                            data-duration="{{ $movie->duration_minutes }}"
                            {{ old('movie_id', $showtime->movie_id ?? '') == $movie->id ? 'selected' : '' }}>
                        {{ $movie->title }} ({{ $movie->duration_minutes }} mins)
                    </option>
                @endforeach
            </select>
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
    <input type="datetime-local" class="form-control" id="start_time" name="start_time"
           value="{{ old('start_time', isset($showtime) ? date('Y-m-d\TH:i', strtotime($showtime->start_time)) : '') }}" required>
</div>

        <!-- End Time (Read-only, auto-calculated) -->
        <div class="col-md-6">
            <div class="form-group">
                <label for="end_time">End Time (Auto-calculated)</label>
                <input type="datetime-local" class="form-control" id="end_time" name="end_time" readonly>
                <small class="form-text text-muted">End time is automatically calculated based on movie duration</small>
            </div>
        </div>
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


