$(function() {
  // Open complaint modal when clicking a room button (assumes .room-btn elements)
  $(document).on('click', '.room-btn', function(e) {
    var roomId = $(this).data('room-id');
    var roomNumber = $(this).data('room-number');
    var roomTypeId = $(this).data('room-type-id');

    $('#complaint_room_id').val(roomId);
    $('#complaint_room_number').val(roomNumber);
    if (roomTypeId) $('#complaint_room_type').val(roomTypeId);

    // Reset items container to a single input
    $('#complaintItemsContainer').html(`
      <label>Add Custom Complaint</label>
      <div class="complaint-item row mb-2">
        <div class="col-9"><input type="text" name="items[0][title]" class="form-control" placeholder="Type custom complaint"/></div>
        <div class="col-3"><button type="button" class="btn btn-secondary add-complaint-item">+</button></div>
      </div>
    `);

    $('#complaintModal').modal('show');
  });

  // Add complaint item input
  $(document).on('click', '.add-complaint-item', function() {
    var count = $('#complaintItemsContainer .complaint-item').length;
    $('#complaintItemsContainer').append(`
      <div class="complaint-item row mb-2">
        <div class="col-9"><input type="text" name="items[`+count+`][title]" class="form-control" placeholder="Type custom complaint"/></div>
        <div class="col-3"><button type="button" class="btn btn-danger remove-complaint-item">-</button></div>
      </div>
    `);
  });

  $(document).on('click', '.remove-complaint-item', function() {
    $(this).closest('.complaint-item').remove();
  });

  // Submit complaint form
  $('#complaintForm').on('submit', function(e) {
    e.preventDefault();
    var data = $(this).serializeArray();
    $.ajax({
      url: '/complaints',
      method: 'POST',
      data: $(this).serialize(),
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(res) {
        if (res.success) {
          $('#complaintModal').modal('hide');
          updateComplaintSummary(); // refresh count & UI
          // Optionally style the room element
          var rid = $('#complaint_room_id').val();
          $('.room-btn[data-room-id="'+rid+'"]').addClass('room-complaint'); // use CSS to color
        } else {
          alert('Failed to create complaint');
        }
      },
      error: function(xhr) {
        alert('Error creating complaint');
      }
    });
  });

  // Clear all complaint inputs
  $('#clearComplaints').click(function(){
    $('#complaintItemsContainer').html('');
  });

  // Load summary and mark rooms with complaints
  function updateComplaintSummary() {
    $.get('/complaints/summary', function(res) {
      // Update complaint count
      $('#complaintRoomsCount').text(res.count || 0);

      // Remove previous marking
      $('.room-btn').removeClass('room-complaint');

      // Mark rooms with complaints
      if (res.rooms && res.rooms.length) {
        res.rooms.forEach(function(roomId) {
          $('.room-btn[data-room-id="'+roomId+'"]').addClass('room-complaint');
        });
      }
    });
  }

  // Initial load
  updateComplaintSummary();
});