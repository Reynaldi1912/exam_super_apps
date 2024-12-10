@extends('app')

@section('content')
<!-- Table -->
<table class="table table-striped">
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
    <tr data-id="1">
      <th scope="row">1</th>
      <td>Yasril</td>
      <td>Kelas 7A</td>
      <td>
        <i class="fa fa-close text-danger" id="status-icon"></i>
      </td>
      <td>
        <!-- Edit button triggers the edit modal -->
        <button class="btn btn-warning" onclick="openEditModal(1, 'Yasril', 'Kelas 7A', 'Inactive')"><i class="fa fa-pencil"></i></button>
        <!-- Delete button triggers the delete modal -->
        <button class="btn btn-danger" onclick="openDeleteModal(1)"><i class="fa fa-trash"></i></button>
      </td>
    </tr>
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
            <input type="text" class="form-control" id="username" placeholder="Enter username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password">
          </div>
          <div class="form-group">
            <label for="grouping">Grouping</label>
            <select class="form-control" id="grouping">
              <option value="Kelas 7A">Kelas 7A</option>
              <option value="Kelas 8B">Kelas 8B</option>
              <option value="Kelas 9C">Kelas 9C</option>
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
  });
</script>
@endsection
