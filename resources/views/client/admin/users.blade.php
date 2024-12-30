@extends('app')

@section('content')
@php
  $menus_name = 'Users'
@endphp
<!-- Table -->
<div class="col-xl-12 text-right mb-3">
    <button class="btn btn-success text" data-toggle="modal" data-target="#addUser"> Add User</button>
</div>
<table class="table table-striped" id="usersTable">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Grouping</th>
      <th scope="col">Active</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody>
   
  </tbody>
</table>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username_edit" placeholder="Enter username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password_edit" placeholder="Enter password">
          </div>
          <div class="form-group">
            <label for="grouping">Grouping</label>
            <select class="form-control listGrouping" id="listGrouping_edit">
         
            </select>
          </div>
          <div class="form-group">
            <label for="status">Account Status</label>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="statusSwitch">
              <label class="custom-control-label" for="statusSwitch">Active</label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addQuestionBankModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuestionBankModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addQuestionBankForm">
          @csrf
          <div class="form-group">
            <label for="bankName">Username</label>
            <input type="text" class="form-control" id="username_add" name="name" placeholder="Enter Username" required>
          </div>
          <div class="form-group">
            <label for="grouping">Grouping</label>
            <select class="form-control listGrouping" id="listGrouping_add">
         
            </select>
          </div>
          <div class="form-group">
            <label for="grouping">Passowrd</label>
            <input type="text" class="form-control" id="password_add" name="name" placeholder="Enter Password" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="saveQuestionBank()">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="deleteUserButton">Delete</button>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    // Open Edit Modal with pre-populated data
    $('#listGrouping').select2({
        placeholder: 'Pilih Grouping',
        allowClear: true,
        width: '100%'
    });

    loadGroupings();

    loadUsers();
    window.openEditModal = function(id, username, grouping, status) {
      $('#username').val(username);
      $('#grouping').val(grouping);
      $('#statusSwitch').prop('checked', status === 'Active');
      $('#editModal').data('id', id); // Store the user ID in the modal
      $('#editModal').modal('show');
    }

    // Open Delete Modal and store the user ID
    window.openDeleteModal = function(id) {
      $('#deleteModal').data('id', id); // Store the user ID in the modal
      $('#deleteModal').modal('show');
    }
  });


  
    // Save Changes for Edit Modal
    $('#saveChangesButton').on('click', function () {
      var userId = $('#editModal').data('id');
      var username = $('#username').val();
      var password = $('#password').val();
      var grouping = $('#grouping').val();
      var status = $('#statusSwitch').prop('checked') ? 'Active' : 'Inactive';

      $.ajax({
        url: '/update-user/' + userId,
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          username: username,
          password: password,
          grouping: grouping,
          status: status
        },
        success: function (response) {
          alert('User updated successfully!');
          $('#editModal').modal('hide');
          location.reload(); // Reload the page to reflect changes
        },
        error: function (error) {
          alert('Error updating user.');
        }
      });
    });

    // Confirm Delete User
    $('#deleteUserButton').on('click', function () {
      var userId = $('#deleteModal').data('id');

      $.ajax({
        url: '/delete-user/' + userId, // Delete URL with the user ID
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          alert('User deleted successfully!');
          $('#deleteModal').modal('hide');
          location.reload(); // Reload the page to reflect changes
        },
        error: function (error) {
          alert('Error deleting user.');
        }
      });
    });
  function loadUsers() {
      $.ajax({
        url: `{{ config('app.url') }}/users-exam?userId=`+'{{Session::get('user_id')}}',
        type: 'GET',
        success: function (response) {
          const tableBody = $('#usersTable tbody');
  
          tableBody.empty();
          console.log(response);
          response.data.forEach((data , index) => {
            const row = `
                        <tr data-id="${index + 1}">
                          <th scope="row">${index + 1}</th>
                          <td>${data.username}</td>
                          <td>${data.grouping_name}</td>
                          <td>
                            ${data.is_active == 0 
                              ? '<i class="fa fa-close text-danger" id="status-icon"></i>' 
                              : '<i class="fa fa-check text-success" id="status-icon"></i>'}
                          </td>
                          <td>
                            <!-- Edit button triggers the edit modal -->
                            <button class="btn btn-warning" onclick="openEditModal(${data.id}, '${data.username}', '${data.grouping_name}', '${data.is_active == 0 ? 'Inactive' : 'Active'}')">
                              <i class="fa fa-pencil"></i>
                            </button>
                            <!-- Delete button triggers the delete modal -->
                            <button class="btn btn-danger" onclick="openDeleteModal(${data.id})">
                              <i class="fa fa-trash"></i>
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

  function loadGroupings() {
      const selectElement = $('.listGrouping');

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
</script>
@endsection
