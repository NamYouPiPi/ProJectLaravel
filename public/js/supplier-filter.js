// Debounce function
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

document.addEventListener('DOMContentLoaded', function() {
    // Handle search input with debouncing
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        const debouncedSubmit = debounce(() => {
            document.getElementById('filterForm').submit();
        }, 500);

        searchInput.addEventListener('input', debouncedSubmit);

        // Clear search on ESC key
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                document.getElementById('filterForm').submit();
            }
        });
    }

    // Highlight table rows on hover
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.cursor = 'pointer';
        });
    });
});
