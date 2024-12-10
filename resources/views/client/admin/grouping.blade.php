@extends('app')
@section('content')
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Name</th>
      <th scope="col">Level</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Kelas 7A</td>
      <td>7</td>
      <td>
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="fa fa-pencil"></i>
        </button>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
  </tbody>
</table>@extends('app')

@section('content')
<div class="container">
  <!-- Table -->
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Name</th>
        <th scope="col">Level</th>
        <th scope="col">Manage</th>
      </tr>
    </thead>
    <tbody>
      <tr data-id="1">
        <th scope="row">1</th>
        <td>Kelas 7A</td>
        <td>7</td>
        <td>
          <!-- Edit button triggers the edit modal -->
          <button class="btn btn-warning" onclick="openEditModal('Kelas 7A', 7)">
            <i class="fa fa-pencil"></i>
          </button>
          <!-- Delete button triggers the delete modal -->
          <button class="btn btn-danger" onclick="openDeleteModal(1)">
            <i class="fa fa-trash"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editClassForm">
            <div class="mb-3">
              <label for="className" class="form-label">Class Name</label>
              <input type="text" class="form-control" id="className" required>
            </div>
            <div class="mb-3">
              <label for="classLevel" class="form-label">Level</label>
              <input type="number" class="form-control" id="classLevel" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this class?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script>
  $(document).ready(function () {
    // Open Edit Modal
    window.openEditModal = function (name, level) {
      $('#className').val(name);
      $('#classLevel').val(level);
      $('#editModal').modal('show');
    };

    // Open Delete Modal
    window.openDeleteModal = function (id) {
      $('#deleteModal').data('id', id);
      $('#deleteModal').modal('show');
    };

    // Save Changes for Edit Modal
    $('#editClassForm').on('submit', function (e) {
      e.preventDefault();
      const name = $('#className').val();
      const level = $('#classLevel').val();

      $.ajax({
        url: '/update-class', // Update with your Laravel route
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          name: name,
          level: level
        },
        success: function () {
          alert('Class updated successfully!');
          $('#editModal').modal('hide');
          location.reload(); // Reload the page
        },
        error: function () {
          alert('Error updating class.');
        }
      });
    });

    // Confirm Delete
    $('#confirmDeleteButton').on('click', function () {
      const id = $('#deleteModal').data('id');

      $.ajax({
        url: '/delete-class/' + id, // Update with your Laravel route
        method: 'POST',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function () {
          alert('Class deleted successfully!');
          $('#deleteModal').modal('hide');
          location.reload(); // Reload the page
        },
        error: function () {
          alert('Error deleting class.');
        }
      });
    });
  });
</script>
@endsection


<!-- Modal Edit -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Class</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="className" class="form-label">Class Name</label>
            <input type="text" class="form-control" id="className" value="Kelas 7A">
          </div>
          <div class="mb-3">
            <label for="classLevel" class="form-label">Level</label>
            <input type="number" class="form-control" id="classLevel" value="7">
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this class?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
@endsection
