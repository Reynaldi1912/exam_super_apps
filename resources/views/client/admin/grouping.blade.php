@extends('app')

@section('content')
@php
  $menus_name = 'Groupings'
@endphp
<div class="col-xl-12 text-right mb-3">
    <button class="btn btn-success text" data-toggle="modal" data-target="#addGrouping"> Add Grouping</button>
</div>
<div class="container-fluid">
  <!-- Table -->
  <table class="table table-striped" id="groupingsTable">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Name</th>
        <th scope="col">Level</th>
        <th scope="col">Manage</th>
      </tr>
    </thead>
    <tbody>
    
    </tbody>
  </table>


  <div class="modal fade" id="addGrouping" tabindex="-1" role="dialog" aria-labelledby="addQuestionBankModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuestionBankModalLabel">Add Question Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addQuestionBankForm">
          @csrf
          <div class="form-group">
            <label for="bankName">Nama Bank Soal</label>
            <input type="text" class="form-control" id="bankName" name="name" placeholder="Enter bank name" required>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter description"></textarea>
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
              <label for="className" class="form-label">Name</label>
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

    loadGroupings();
  });


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

  function loadGroupings() {
      $.ajax({
        url: `{{ config('app.url') }}/groupings?userId=`+'{{Session::get('user_id')}}',
        type: 'GET',
        success: function (response) {
          const tableBody = $('#groupingsTable tbody');
  
          tableBody.empty();
          console.log(response);
          response.data.forEach((data , index) => {
            const row = `
                <tr data-id="${index + 1}">
                  <th scope="row">${index + 1}</th>
                  <td>${data.name}</td>
                  <td>${data.level}</td>
                  <td>
                    <!-- Edit button triggers the edit modal -->
                    <button class="btn btn-warning" onclick="openEditModal('${data.name}', ${data.level})">
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
</script>


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