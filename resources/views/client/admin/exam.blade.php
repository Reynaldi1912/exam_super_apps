@extends('app')

@section('content')

<table class="table table-striped"  id="groupingsTable">
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
          <option value="1">Kelas 7A</option>
          <option value="2">Kelas 7B</option>
          <option value="3">Kelas 7C</option>
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
          <option value="1">Reynaldi</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
      $.ajax({
        url: `{{ config('app.url') }}/exams?userId=`+'{{Session::get('user_id')}}', // Endpoint to fetch groupings
        type: 'GET',
        success: function (response) {
          const tableBody = $('#groupingsTable tbody');

          tableBody.empty();
          console.log(response);
          response.data.forEach(data => {
            const row = `
              <tr data-id="1">
                <th scope="row">1</th>
                <td>${data.name}</td>
                <td>${data.date}</td>
                <td>${data.start_date}</td>
                <td>${data.end_date}</td>
                <td>  
                  <button class="btn btn-primary manage-grouping-btn" data-id="1" data-groupings=${data.grouping_list_ids}>
                    ${data.grouping_count} <i class="fa fa-users"></i>

                  </button></td>
                <td>
                  <!-- Edit Exam Button -->
                  <button class="btn btn-warning edit-exam-btn" data-id="1" data-name="Math Exam" data-date="2024-12-10" 
                    data-start="08:00" data-end="10:00" data-groupings="">
                    <i class="fa fa-pencil"></i>
                  </button>                

                  <button class="btn btn-danger except-users-btn" data-id="1" data-users=${data.except_user_ids}>
                    ${data.except_users}
                     <i class="fa fa-ban"></i>
                  </button>
                </td>
              </tr>
            `;
            tableBody.append(row);
          });
        },
        error: function () {
          alert('Error loading groupings. Please try again.');
        }
      });

    // Initialize Select2
    $('.select2').select2({
      width: '100%',
      placeholder: 'Select an option',
      allowClear: true
    });

    // Handle Edit Exam Button Click
    $(document).on('click', '.edit-exam-btn', function () {
      const button = $(this);
      const examId = button.data('id');

      $('#editExamForm').find('#examName').val(button.data('name'));
      $('#editExamForm').find('#examDate').val(button.data('date'));
      $('#editExamForm').find('#startTime').val(button.data('start'));
      $('#editExamForm').find('#endTime').val(button.data('end'));

      $('#editExamForm').off('submit').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
          url: `/update-exam/${examId}`,
          type: 'POST',
          data: formData,
          success: function (response) {
            alert('Exam updated successfully!');
            location.reload();
          },
          error: function (xhr) {
            alert('Error updating exam. Please try again.');
          }
        });
      });

      $('#editExamModal').modal('show');
    });

    $(document).on('click', '.manage-grouping-btn', function () {
      const button = $(this);
      const examId = button.data('id');
      const groupingsData = button.data('groupings'); // Ambil data dari atribut
      const groupings = String(groupingsData).split(',');

      $('#listGrouping').val(groupings).trigger('change');

      $('#manageGroupingModal').off('submit').on('submit', function (e) {
        e.preventDefault();

        const selectedGroupings = $('#listGrouping').val();

        $.ajax({
          url: `/update-groupings/${examId}`,
          type: 'POST',
          data: { groupings: selectedGroupings },
          success: function (response) {
            alert('Groupings updated successfully!');
            location.reload();
          },
          error: function (xhr) {
            alert('Error updating groupings. Please try again.');
          }
        });
      });

      $('#manageGroupingModal').modal('show');
    });

    // Handle Except Users Button Click
    $(document).on('click', '.except-users-btn', function () {
      const button = $(this);
      const examId = button.data('id');
      const usersData = button.data('users'); // Ambil data dari atribut
      const users = String(usersData).split(',');
      $('#exceptUsersSelect').val(users).trigger('change');

      $('#exceptUsersModal').off('submit').on('submit', function (e) {
        e.preventDefault();

        const excludedUsers = $('#exceptUsersSelect').val();

        $.ajax({
          url: `/update-excluded-users/${examId}`,
          type: 'POST',
          data: { excluded_users: excludedUsers },
          success: function (response) {
            alert('Excluded users updated successfully!');
            location.reload();
          },
          error: function (xhr) {
            alert('Error updating excluded users. Please try again.');
          }
        });
      });

      $('#exceptUsersModal').modal('show');
    });
  });
</script>
@endsection



