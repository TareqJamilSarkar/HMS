/**
 * Room Status Dashboard Module
 * Fetches and applies room status colors to room buttons
 */

const RoomStatusDashboard = {
    statusClasses: {
        'normal_checkout': 'status-normal-checkout',
        'early_checkin': 'status-early-checkin',
        'early_checkout': 'status-early-checkout',
        'late_checkout': 'status-late-checkout',
        'booked': 'status-booked'
    },

    /**
     * Load room statuses for a given date
     */
    loadRoomStatuses: async function(date = null) {
        try {
            const queryDate = date || new Date().toISOString().split('T')[0];
            const response = await fetch(`/api/room-statuses?date=${queryDate}`);

            if (!response.ok) {
                console.error('Failed to load room statuses:', response.statusText);
                return false;
            }

            const data = await response.json();
            console.log('Room statuses loaded:', data);

            return this.applyStatuses(data.statuses);
        } catch (error) {
            console.error('Error loading room statuses:', error);
            return false;
        }
    },

    /**
     * Apply status classes to room buttons
     */
    applyStatuses: function(statuses) {
        let count = 0;

        Object.entries(statuses).forEach(([roomId, status]) => {
            const roomBtn = document.querySelector(`.room-btn[data-room-id="${roomId}"]`);

            if (roomBtn) {
                // Remove all status classes
                Object.values(this.statusClasses).forEach(cls => {
                    roomBtn.classList.remove(cls);
                });

                // Add new status class
                const statusClass = this.statusClasses[status] || this.statusClasses['booked'];
                roomBtn.classList.add(statusClass);
                count++;
            }
        });

        console.log(`Applied status classes to ${count} room buttons`);
        return true;
    },

    /**
     * Build status counters
     */
    buildCounters: function(statuses) {
        const counters = {
            normal_checkout: 0,
            early_checkin: 0,
            early_checkout: 0,
            late_checkout: 0,
            booked: 0
        };

        Object.values(statuses).forEach(status => {
            if (counters.hasOwnProperty(status)) {
                counters[status]++;
            }
        });

        return counters;
    },

    /**
     * Initialize the dashboard
     */
    init: function() {
        const initFunc = () => {
            this.loadRoomStatuses();
        };

        // If DOM is already loaded, run immediately
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFunc);
        } else {
            initFunc();
        }
    }
};

// Auto-initialize when included
RoomStatusDashboard.init();

// Expose globally for manual calls
window.loadRoomStatuses = (date) => RoomStatusDashboard.loadRoomStatuses(date);
