@extends('app')

@section('content')
@php
  $menus_name = 'Exams'
@endphp
<div class="col-xl-12 text-right mb-3">
    <button class="btn btn-success text"> Add Exam</button>
</div>
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





<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addExamModalLabel">Add Exam</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addExamForm">
          @csrf
          <div class="form-group">
            <label for="addExamName">Exam Name</label>
            <input type="text" class="form-control" id="addExamName" name="name" placeholder="Enter exam name" required>
          </div>
          <div class="form-group">
            <label for="addExamDate">Exam Date</label>
            <input type="date" class="form-control" id="addExamDate" name="date" required>
          </div>
          <div class="form-group">
            <label for="addStartTime">Start Time</label>
            <input type="time" class="form-control" id="addStartTime" name="start_time" required>
          </div>
          <div class="form-group">
            <label for="addEndTime">End Time</label>
            <input type="time" class="form-control" id="addEndTime" name="end_time" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveNewExam()">Save Exam</button>
      </div>
    </div>
  </div>
</div>
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
            <button type="button" class="btn btn-primary" onclick="saveExam()">Save Changes</button>
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
        <select class="form-control select2"  id="listGrouping"  name="groupings[]" multiple>
       
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveGroupings()">Save</button>
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
        <select class="form-control select2" id="listUser" name="excluded_users[]" multiple>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveExcludedUsers()">Save</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
 
    $('#listGrouping').select2({
        placeholder: 'Pilih Grouping',
        allowClear: true,
        width: '100%'
    });
    $('#listUser').select2({
        placeholder: 'Pilih Users',
        allowClear: true,
        width: '100%'
    });

    loadTable();
    loadGroupings();
    loadUsers();
  });
</script>


<script>
    $(document).on('click', '.btn-success', function () {
      $('#addExamModal').modal('show');
    });

  function saveNewExam() {
    const data = {
      name: $('#addExamName').val(),
      date: $('#addExamDate').val(),
      start_time: $('#addStartTime').val(),
      end_time: $('#addEndTime').val()
    };

    $.ajax({
      url: '/create-exam', // Adjust the endpoint as per your routes
      type: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      data,
      success: function (response) {
        alert('Exam added successfully!');
        $('#addExamModal').modal('hide');
        $('#addExamForm')[0].reset(); // Reset form
        loadTable(); // Reload table data
      },
      error: function (xhr) {
        alert('Failed to add exam. Please try again.');
      }
    });
  }
  function loadTable(){
    $.ajax({
        url: `{{ config('app.url') }}/exams?userId=`+'{{Session::get('user_id')}}', // Endpoint to fetch groupings
        type: 'GET',
        success: function (response) {
          const tableBody = $('#groupingsTable tbody');
  
          tableBody.empty();
          console.log(response);
          response.data.forEach((data,index) => {
            const row = `
              <tr data-id="${index + 1}">
                <th scope="row">${index + 1}</th>
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
  }

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

      console.log(users);
      
      $('#listUser').val(users).trigger('change');

      $('#exceptUsersModal').off('submit').on('submit', function (e) {
        e.preventDefault();

        const excludedUsers = $('#listUser').val();

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

    function loadGroupings() {
      const selectElement = $('#listGrouping');

        $.ajax({
            url: `{{ config('app.url') }}/groupings?userId=`+'{{Session::get('user_id')}}',
            type: 'GET',
            success: function (response) {
              if (response.success && response.data) {
                  selectElement.empty();

                  response.data.forEach(function(grouping) {
                      const option = $('<option></option>')
                          .val(grouping.id) 
                          .text(grouping.name);
                      selectElement.append(option);
                  });
                } else {
                    alert(response.message || 'Failed to load data.');
                }
            },
            error: function () {
                alert('Gagal memuat data groupings.');
            }
        });
    }

    function loadUsers() {
      const selectElementUser = $('#listUser');
        $.ajax({
            url: `{{ config('app.url') }}/users-master?userId=`+'{{Session::get('user_id')}}',
            type: 'GET',
            success: function (response) {
              if (response.success && response.data) {
                selectElementUser.empty();
                  console.log(response.data);
                  
                  response.data.forEach(function(users) {
                      const option = $('<option></option>')
                          .val(users.id) 
                          .text(users.username);
                          selectElementUser.append(option);
                  });
                } else {
                    alert(response.message || 'Failed to load data.');
                }
            },
            error: function () {
                alert('Gagal memuat data groupings.');
            }
        });
    }

    function saveExam() {
      const examId = $('#editExamId').val();
      const data = {
        name: $('#examName').val(),
        date: $('#examDate').val(),
        start_time: $('#startTime').val(),
        end_time: $('#endTime').val()
      };

      $.ajax({
        url: `/update-exam/${examId}`,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data,
        success: function () {
          alert('Exam updated successfully!');
          location.reload();
        },
        error: function () {
          alert('Failed to update exam.');
        }
      });
    }

    function saveGroupings() {
      const examId = $('#manageGroupingModal').data('exam-id');
      const selectedGroupings = $('#listGrouping').val();

      $.ajax({
        url: `/update-groupings/${examId}`,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: { groupings: selectedGroupings },
        success: function () {
          alert('Groupings updated successfully!');
          location.reload();
        },
        error: function () {
          alert('Failed to update groupings.');
        }
      });
    }

    function saveExcludedUsers() {
      const examId = $('#exceptUsersModal').data('exam-id');
      const excludedUsers = $('#listUser').val();

      $.ajax({
        url: `/update-excluded-users/${examId}`,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        data: { excluded_users: excludedUsers },
        success: function () {
          alert('Excluded users updated successfully!');
          location.reload();
        },
        error: function () {
          alert('Failed to update excluded users.');
        }
      });
    }
</script>
@endsection



