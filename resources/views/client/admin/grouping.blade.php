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

  <!-- Add Grouping Modal -->
  <div class="modal fade" id="addGrouping" tabindex="-1" role="dialog" aria-labelledby="addGroupingModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addGroupingModalLabel">Add Grouping</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="addGroupingForm">
            @csrf
            <div class="form-group">
              <label for="groupingName">Name</label>
              <input type="text" class="form-control" id="groupingName" name="name" placeholder="Enter grouping name" required>
            </div>
            <div class="form-group">
              <label for="groupingLevel">Level</label>
              <input type="number" class="form-control" id="groupingLevel" name="level" placeholder="Enter level" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="saveGrouping()">Save</button>
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
          <h5 class="modal-title" id="editModalLabel">Edit Grouping</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editGroupingForm">
            <div class="mb-3">
              <label for="editName" class="form-label">Name</label>
              <input type="text" class="form-control" id="editName" required>
            </div>
            <div class="mb-3">
              <label for="editLevel" class="form-label">Level</label>
              <input type="number" class="form-control" id="editLevel" required>
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
          Are you sure you want to delete this grouping?
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
    loadGroupings();
    
    window.openEditModal = function (id, name, level) {
      $('#editName').val(name);
      $('#editLevel').val(level);
      $('#editModal').data('id', id);
      $('#editModal').modal('show');
    };

    // Open Delete Modal
    window.openDeleteModal = function (id) {
      $('#deleteModal').data('id', id);
      $('#deleteModal').modal('show');
    };

    
  });

  // Save Grouping
  function saveGrouping() {
    const name = $('#groupingName').val();
    const level = $('#groupingLevel').val();

    $.ajax({
      url: '{{ config('app.url') }}/insert-grouping',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        name: name,
        level: level,
        user_id : '{{Session::get('user_id')}}'
      },
      success: function () {
        alert('Grouping added successfully!');
        $('#addGrouping').modal('hide');
        location.reload(); // Reload the page
      },
      error: function () {
        alert('Error adding grouping.');
      }
    });
  }

  // Save Changes for Edit Modal
  $('#editGroupingForm').on('submit', function (e) {
    e.preventDefault();
    const id = $('#editModal').data('id');
    const name = $('#editName').val();
    const level = $('#editLevel').val();

    $.ajax({
      url: '{{ config('app.url') }}/update-grouping',
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        name: name,
        level: level,
        grouping_id : id
      },
      success: function () {
        alert('Grouping updated successfully!');
        $('#editModal').modal('hide');
        location.reload(); // Reload the page
      },
      error: function () {
        alert('Error updating grouping.');
      }
    });
  });

  // Confirm Delete
  $('#confirmDeleteButton').on('click', function () {
    const id = $('#deleteModal').data('id');

    $.ajax({
      url: '{{ config('app.url') }}/delete-grouping', // Ensure this route matches your Laravel route
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        grouping_id: id
      },
      success: function (response) {
        // Handle response message
        if (response.message) {
          alert(response.message);
        } else {
          alert('Grouping deleted successfully!');
        }
        
        $('#deleteModal').modal('hide');
        location.reload(); // Reload the page after successful deletion
      },
      error: function (xhr, status, error) {
        // Handle errors more informatively
        alert('Error deleting grouping: ' + xhr.responseText || error);
      }
    });
});


  function loadGroupings() {
    $.ajax({
      url: `{{ config('app.url') }}/groupings?userId=`+'{{Session::get('user_id')}}',
      method: 'GET',
      success: function (response) {
      console.log(response);
      
        const tableBody = $('#groupingsTable tbody');
        tableBody.empty();
        response.data.forEach((data, index) => {
          const row = `
            <tr data-id="${data.id}">
              <th scope="row">${index + 1}</th>
              <td>${data.name}</td>
              <td>${data.level}</td>
              <td>
                <button class="btn btn-warning" onclick="openEditModal(${data.id}, '${data.name}', ${data.level})">
                  <i class="fa fa-pencil"></i>
                </button>
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
        alert('Error loading groupings.');
      }
    });
  }
</script>
@endsection
