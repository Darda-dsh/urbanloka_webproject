// Modern warehouse.js: ready for filter, search, interaksi UI
// Example: highlight card, filter by category, dsb

document.addEventListener('DOMContentLoaded', function() {
    // Highlight card on hover
    document.querySelectorAll('.glass-card').forEach(card => {
        card.addEventListener('mouseenter', () => card.classList.add('shadow-lg'));
        card.addEventListener('mouseleave', () => card.classList.remove('shadow-lg'));
    });
    // Placeholder: implement filter/search if needed
});
