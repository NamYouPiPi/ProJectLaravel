// Debounce function to limit how often a function can fire
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle search input with debouncing
document.addEventListener('DOMContentLoaded', function() {
    // Handle search input
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        const debouncedSubmit = debounce(() => {
            document.getElementById('filterForm').submit();
        }, 500);

        searchInput.addEventListener('input', debouncedSubmit);
    }

    // Handle checkbox changes
    const reorderAlert = document.getElementById('reorderAlert');
    if (reorderAlert) {
        reorderAlert.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    }
});
