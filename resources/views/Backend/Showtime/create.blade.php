<form action="{{route('showtimes.store')}}" method="post">
    @csrf
    @include('Backend.Showtime.form', ['movies' => $movies, 'hallCinema' => $hallCinema])
</form>

<script>
 function calculateEndTime() {
    if (movieSelect.value && startTimeInput.value) {
        const selectedOption = movieSelect.options[movieSelect.selectedIndex];
        const durationMinutes = parseInt(selectedOption.dataset.duration);

        console.log("Movie ID:", movieSelect.value);
        console.log("Duration:", durationMinutes, "minutes");
        console.log("Start Time:", startTimeInput.value);

        if (durationMinutes) {
            // Parse start time
            const startTime = new Date(startTimeInput.value);

            // Add duration to start time
            const endTime = new Date(startTime.getTime() + durationMinutes * 60000);

            // Format for datetime-local input
            const endTimeStr = endTime.toISOString().slice(0, 16);
            endTimeInput.value = endTimeStr;
            console.log("End Time:", endTimeStr);
        }
    }
}
</script>
