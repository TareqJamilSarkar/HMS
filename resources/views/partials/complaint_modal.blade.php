<div id="complaintModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="complaintForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create Complaint Room</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="room_id" id="complaint_room_id"/>
          <div class="form-group">
            <label>Room Type</label>
            <select name="room_type_id" id="complaint_room_type" class="form-control">
              <option value="">Select</option>
              @foreach($roomTypes as $rt)
                <option value="{{ $rt->id }}">{{ $rt->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>Room Number</label>
            <input type="text" class="form-control" id="complaint_room_number" readonly/>
          </div>

          <div id="complaintItemsContainer">
            <label>Add Custom Complaint</label>
            <div class="complaint-item row mb-2">
              <div class="col-9">
                <input type="text" name="items[0][title]" class="form-control" placeholder="Type custom complaint"/>
              </div>
              <div class="col-3">
                <button type="button" class="btn btn-secondary add-complaint-item">+</button>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" id="clearComplaints">CLEAR ALL COMPLAINTS</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
          <button type="submit" class="btn btn-primary">CREATE COMPLAINT ROOM</button>
        </div>
      </div>
    </form>
  </div>
</div>
