@extends('app')
<style>
  #bankTable {
    /* transform: scale(); */
    transform-origin: top left;
    font-size: 0.8rem;
  }
</style>

@section('content')
  @php
      $menus_name = 'Bank Soal';
  @endphp
  <div class="col-xl-12 text-right mb-3">
    <button class="btn btn-success text" data-toggle="modal" data-target="#addQuestionBankModal"> Add Question Bank</button>
</div>
<!-- Bank Soal Table -->
<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="bankTable">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Bank Soal</th>
          <th scope="col">Jumlah Soal</th>
          <th scope="col" class="w-30">Poin Per Tipe (+)</th>
          <th scope="col" class="w-30">Poin Per Tipe (-)</th>
          <th scope="col">Exams</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be inserted here dynamically -->
      </tbody>
    </table>
  </div>
</div>

<!-- Add Question Bank Modal -->
<div class="modal fade" id="addQuestionBankModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionBankModalLabel" aria-hidden="true">
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

<!-- Edit Question Bank Modal -->
<div class="modal fade" id="editQuestionBankModal" tabindex="-1" role="dialog" aria-labelledby="editQuestionBankModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editQuestionBankModalLabel">Edit Question Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editQuestionBankForm">
          @csrf
          <input type="hidden" id="editBankId" name="id">
          <div class="form-group">
            <label for="editBankName">Nama Bank Soal</label>
            <input type="text" class="form-control" id="editBankName" name="name" required>
          </div>
          <div class="form-group">
            <label for="editExams">Select Exams</label>
            <select class="form-control" id="editExams" name="exams[]" multiple>
              <!-- Options will be populated dynamically -->
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="updateQuestionBank()">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  loadBank();
});

function loadBank() {
  $.ajax({
    url: `{{ config('app.url') }}/bank-question`,
    type: 'GET',
    headers: {
      Authorization: "Bearer " + '{{Session::get('token_user')}}',
      UserId: {{Session::get('user_id')}}
    },
    success: function (response) {
      const tableBody = $('#bankTable tbody');
      tableBody.empty();

      response.data.forEach((data, index) => {
        const row = `
          <tr>
            <th scope="row">${index + 1}</th>
            <td>${data.name}</td>
            <td>
             <ul class="list-unstyled">
              <li>Multiple: <span class="text-dark font-weight-bold">${data.total_multiple}</span></li>
              <li>Complex: <span class="text-dark font-weight-bold">${data.total_complex}</span></li>
              <li>Essay: <span class="text-dark font-weight-bold">${data.total_text}</span></li>
              <li>Match: <span class="text-dark font-weight-bold">${data.total_match}</span></li>
            </ul>
            </td>
            <td>
              <ul class="list-unstyled">
                <li>Multiple:<span class="text-dark font-weight-bold"> ${data.multiple_true_poin}</span></li>
                <li>Complex:<span class="text-dark font-weight-bold"> ${data.complex_true_poin}</span></li>
                <li>Match:<span class="text-dark font-weight-bold"> ${data.match_true_poin}</span></li>
              </ul>
            </td>
            <td>
              <ul class="list-unstyled">
                <li>Multiple:<span class="text-dark font-weight-bold"> ${data.multiple_false_poin}</span></li>
                <li>Complex:<span class="text-dark font-weight-bold"> ${data.complex_false_poin}</span></li>
                <li>Match:<span class="text-dark font-weight-bold"> ${data.match_false_poin}</span></li>
              </ul>
            </td>
            <td>
              <ul class="list-unstyled">
                <li>Matematika Ujian 1</span></li>
              </ul>
            </td>
            <td>
              <a href="/question-bank/${data.id}" class="btn btn-primary btn-sm">Go to Question Bank</a>
              <button class="btn btn-warning btn-sm" onclick="editQuestionBank(${data.id})">Edit</button>
            </td>
          </tr>
        `;
        tableBody.append(row);
      });
    },
    error: function () {
      alert('Error loading bank. Please try again.');
    }
  });
}

function saveQuestionBank() {
  const formData = $('#addQuestionBankForm').serialize();

  $.ajax({
    url: `{{ config('app.url') }}/create-bank-question`,
    type: 'POST',
    headers: {
      Authorization: "Bearer " + '{{Session::get('token_user')}}',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    data: formData,
    success: function (response) {
      alert('Question Bank created successfully!');
      location.reload();
    },
    error: function (xhr) {
      alert('Error creating question bank. Please try again.');
    }
  });
}

function editQuestionBank(id) {
  $.ajax({
    url: `{{ config('app.url') }}/bank-question/${id}`,
    type: 'GET',
    headers: {
      Authorization: "Bearer " + '{{Session::get('token_user')}}'
    },
    success: function (response) {
      const data = response.data;
      $('#editBankId').val(data.id);
      $('#editBankName').val(data.name);
      $('#editExams').empty();

      response.exams.forEach(exam => {
        $('#editExams').append(`<option value="${exam.id}" ${data.exams.includes(exam.id) ? 'selected' : ''}>${exam.name}</option>`);
      });

      $('#editQuestionBankModal').modal('show');
    },
    error: function () {
      alert('Error fetching question bank details.');
    }
  });
}

function updateQuestionBank() {
  const formData = $('#editQuestionBankForm').serialize();

  $.ajax({
    url: `{{ config('app.url') }}/update-bank-question`,
    type: 'POST',
    headers: {
      Authorization: "Bearer " + '{{Session::get('token_user')}}',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    data: formData,
    success: function (response) {
      alert('Question Bank updated successfully!');
      location.reload();
    },
    error: function () {
      alert('Error updating question bank.');
    }
  });
}
</script>
@endsection
