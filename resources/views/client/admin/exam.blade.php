@extends('app')

@section('content')
<!-- Table -->
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Exam Name</th>
      <th scope="col">Date</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
      <th scope="col">List Grouping</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr data-id="1">
      <th scope="row">1</th>
      <td>Math Exam</td>
      <td>2024-12-10</td>
      <td>08:00</td>
      <td>10:00</td>
      <td>Kelas 7A, Kelas 8B</td>
      <td>
        <!-- Edit Exam Button -->
        <button class="btn btn-warning" data-toggle="modal" data-target="#editExamModal" 
          data-id="1" data-name="Math Exam" data-date="2024-12-10" 
          data-start="08:00" data-end="10:00" data-groupings="Kelas 7A,Kelas 8B">
          <i class="fa fa-pencil"></i>
        </button>

        <!-- Manage Grouping Button -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#manageGroupingModal" 
          data-groupings="Kelas 7A,Kelas 8B">
          Manage Grouping
        </button>

        <!-- Except Users Button -->
        <button class="btn btn-danger" data-toggle="modal" data-target="#exceptUsersModal" 
          data-users="user1,user2">
          Except Users
        </button>
      </td>
    </tr>
  </tbody>
</table>

<!-- Edit Exam Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="editExamModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editExamModalLabel">Edit Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editExamForm" action="/update-exam" method="POST">
          @csrf
          <div class="form-group">
            <label for="examName">Exam Name</label>
            <input type="text" class="form-control" id="examName" name="name" placeholder="Enter exam name">
          </div>
          <div class="form-group">
            <label for="examDate">Exam Date</label>
            <input type="date" class="form-control" id="examDate" name="date">
          </div>
          <div class="form-group">
            <label for="startTime">Start Time</label>
            <input type="time" class="form-control" id="startTime" name="start_time">
          </div>
          <div class="form-group">
            <label for="endTime">End Time</label>
            <input type="time" class="form-control" id="endTime" name="end_time">
          </div>
         
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Manage Grouping Modal -->
<div class="modal fade" id="manageGroupingModal" tabindex="-1" role="dialog" aria-labelledby="manageGroupingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageGroupingModalLabel">Manage Grouping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="grouping">Select Group</label>
        <select class="form-control select2" id="listGrouping" name="groupings[]" multiple>
          <option value="Kelas 7A">Kelas 7A</option>
          <option value="Kelas 8B">Kelas 8B</option>
          <option value="Kelas 9C">Kelas 9C</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Except Users Modal -->
<div class="modal fade" id="exceptUsersModal" tabindex="-1" role="dialog" aria-labelledby="exceptUsersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exceptUsersModalLabel">Manage Except Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="exceptUsers">Select Users to Exclude</label>
        <select class="form-control select2" id="exceptUsersSelect" name="excluded_users[]" multiple>
          <option value="user1">User 1</option>
          <option value="user2">User 2</option>
          <option value="user3">User 3</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Initialize Select2 for all select elements
    $('.select2').select2({
      width: '100%',  // Full width
      placeholder: 'Select an option',
      allowClear: true  // Allow clearing the selection
    });

    // For the Manage Grouping Modal
    $('#manageGroupingModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);  // Button that triggered the modal
      var groupings = button.data('groupings');  // Get data from the button
      var modal = $(this);
      
      // Split the groupings string into an array
      var selectedGroupings = groupings ? groupings.split(',') : [];
      
      // Set the selected groupings in Select2
      modal.find('#listGrouping').val(selectedGroupings).trigger('change');
    });

    // For the Except Users Modal
    $('#exceptUsersModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);  // Button that triggered the modal
      var users = button.data('users');  // Get data from the button
      var modal = $(this);

      // Split the users string into an array
      var selectedUsers = users ? users.split(',') : [];
      
      // Set the selected users in Select2
      modal.find('#exceptUsersSelect').val(selectedUsers).trigger('change');
    });
  });
</script>
@endsection
