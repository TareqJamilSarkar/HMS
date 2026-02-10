/**
 * Room Search Module
 * Handles room filtering by room number and category/type in Quick Room Status
 */

const RoomSearch = {
    /**
     * Initialize room search
     */
    init: function() {
        this.cacheElements();
        this.attachEventListeners();
    },

    /**
     * Cache DOM elements
     */
    cacheElements: function() {
        this.searchInput = document.getElementById('room-search-input');
        this.categoryFilter = document.getElementById('room-category-filter');
        this.searchBtn = document.getElementById('room-search-btn');
        this.clearBtn = document.getElementById('room-clear-btn');
        this.roomContainer = document.getElementById('room-status-container');
        this.roomBtns = document.querySelectorAll('.room-btn');
    },

    /**
     * Attach event listeners
     */
    attachEventListeners: function() {
        if (this.searchBtn) {
            this.searchBtn.addEventListener('click', () => this.performSearch());
        }

        if (this.clearBtn) {
            this.clearBtn.addEventListener('click', () => this.clearSearch());
        }

        if (this.categoryFilter) {
            this.categoryFilter.addEventListener('change', () => this.applyFilters());
        }

        if (this.searchInput) {
            // Allow Enter key to trigger search
            this.searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.performSearch();
                }
            });

            // Real-time filtering as user types
            this.searchInput.addEventListener('input', (e) => {
                this.applyFilters();
            });
        }
    },

    /**
     * Perform search
     */
    performSearch: function() {
        this.applyFilters();
    },

    /**
     * Apply combined search and category filters
     */
    applyFilters: function() {
        const searchTerm = this.searchInput ? this.searchInput.value.toLowerCase().trim() : '';
        const selectedCategory = this.categoryFilter ? this.categoryFilter.value.toLowerCase().trim() : '';

        let visibleCount = 0;

        this.roomBtns.forEach((btn) => {
            const roomNumber = btn.getAttribute('data-room-number');
            const roomType = btn.getAttribute('data-room-type');
            const parentCol = btn.closest('.col-lg-2');

            // Check if room matches both search term and category filter
            const matchesSearch = !searchTerm || (roomNumber && roomNumber.includes(searchTerm));
            const matchesCategory = !selectedCategory || (roomType && roomType.toLowerCase() === selectedCategory);

            if (matchesSearch && matchesCategory) {
                parentCol.style.display = '';
                visibleCount++;
            } else {
                parentCol.style.display = 'none';
            }
        });

        // Show "no results" message if needed
        this.updateNoResultsMessage(visibleCount);
    },

    /**
     * Show all rooms
     */
    showAllRooms: function() {
        this.roomBtns.forEach((btn) => {
            const parentCol = btn.closest('.col-lg-2');
            parentCol.style.display = '';
        });

        // Remove no results message
        this.removeNoResultsMessage();
    },

    /**
     * Clear search
     */
    clearSearch: function() {
        if (this.searchInput) {
            this.searchInput.value = '';
            this.searchInput.focus();
        }

        if (this.categoryFilter) {
            this.categoryFilter.value = '';
        }

        this.showAllRooms();
    },

    /**
     * Update no results message
     */
    updateNoResultsMessage: function(visibleCount) {
        // Remove existing message first
        this.removeNoResultsMessage();

        if (visibleCount === 0) {
            const noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'col-12 text-center text-muted mt-3';
            noResultsDiv.id = 'room-no-results-msg';
            noResultsDiv.innerHTML = '<p><i class="fas fa-search me-2"></i>No rooms found matching your search.</p>';
            this.roomContainer.appendChild(noResultsDiv);
        }
    },

    /**
     * Remove no results message
     */
    removeNoResultsMessage: function() {
        const existingMsg = document.getElementById('room-no-results-msg');
        if (existingMsg) {
            existingMsg.remove();
        }
    }
};

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('room-search-input')) {
        RoomSearch.init();
    }
});

// Expose globally
window.RoomSearch = RoomSearch;
