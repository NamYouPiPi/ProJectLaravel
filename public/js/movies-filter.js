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

// Handle search inputs with debouncing
document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = [
        document.querySelector('input[name="search"]'),
    ];

    searchInputs.forEach(input => {
        if (input) {
            const debouncedSubmit = debounce(() => {
                document.getElementById('filterForm').submit();
            }, 500);

            input.addEventListener('input', debouncedSubmit);

            // Clear individual filter
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    input.value = '';
                    document.getElementById('filterForm').submit();
                }
            });
        }
    });
});
