@extends('app')
<style>
  #bankTable {
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

            <!-- Multiple Choice -->
            <div class="form-group">
              <h6>Multiple Choice</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="multipleCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="multipleCorrectPoints" name="multiple_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="multipleWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="multipleWrongPoints" name="multiple_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
            </div>

            <!-- Complex -->
            <div class="form-group">
              <h6>Complex</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="complexCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="complexCorrectPoints" name="complex_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="complexWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="complexWrongPoints" name="complex_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
            </div>

            <!-- Match -->
            <div class="form-group">
              <h6>Match</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="matchCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="matchCorrectPoints" name="match_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="matchWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="matchWrongPoints" name="match_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
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
            <input type="hidden" id="editQuestionBankId" name="id">

            <div class="form-group">
              <label for="editBankName">Nama Bank Soal</label>
              <input type="text" class="form-control" id="editBankName" name="name" required>
            </div>
         

            <!-- Multiple Choice -->
            <div class="form-group">
              <h6>Multiple Choice</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="editMultipleCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="editMultipleCorrectPoints" name="multiple_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="editMultipleWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="editMultipleWrongPoints" name="multiple_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
            </div>

            <!-- Complex -->
            <div class="form-group">
              <h6>Complex</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="editComplexCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="editComplexCorrectPoints" name="complex_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="editComplexWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="editComplexWrongPoints" name="complex_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
            </div>

            <!-- Match -->
            <div class="form-group">
              <h6>Match</h6>
              <div class="row">
                <div class="col-md-6">
                  <label for="editMatchCorrectPoints">Poin Jawaban Benar</label>
                  <input type="number" class="form-control" id="editMatchCorrectPoints" name="match_correct_points" placeholder="Masukkan poin untuk jawaban benar" required>
                </div>
                <div class="col-md-6">
                  <label for="editMatchWrongPoints">Poin Jawaban Salah</label>
                  <input type="number" class="form-control" id="editMatchWrongPoints" name="match_wrong_points" placeholder="Masukkan poin untuk jawaban salah" required>
                </div>
              </div>
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
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editQuestionBankModal" data-id="${data.id}" data-name="${data.name}" data-description="${data.description}" data-multiple-true="${data.multiple_true_poin}" data-multiple-false="${data.multiple_false_poin}" data-complex-true="${data.complex_true_poin}" data-complex-false="${data.complex_false_poin}" data-match-true="${data.match_true_poin}" data-match-false="${data.match_false_poin}" onclick="editQuestionBank(this)">Edit</button>
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
    // Serialize form data
    let formData = $('#addQuestionBankForm').serialize(); // Mengubah form ke string URL-encoded
    formData += `&user_id={{Session::get('user_id')}}`;

    // Kirim permintaan AJAX
    $.ajax({
      url: `{{ config('app.url') }}/post-question-bank`,
      type: 'POST',
      data: formData,
      success: function (response) {
        alert('Question Bank created successfully!');
        location.reload();
      },
      error: function (xhr) {
        let errorMessage = 'Error creating question bank. Please try again.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMessage = xhr.responseJSON.message;
        }
        alert(errorMessage);
      }
    });
  }

  function editQuestionBank(button) {
  const id = button.getAttribute('data-id');
  console.log(id);
  
  const name = button.getAttribute('data-name');
  const multipleTrue = button.getAttribute('data-multiple-true');
  const multipleFalse = button.getAttribute('data-multiple-false');
  const complexTrue = button.getAttribute('data-complex-true');
  const complexFalse = button.getAttribute('data-complex-false');
  const matchTrue = button.getAttribute('data-match-true');
  const matchFalse = button.getAttribute('data-match-false');

  // Populate the form fields with the data
  document.getElementById('editQuestionBankId').value = id;
  document.getElementById('editBankName').value = name;
  document.getElementById('editMultipleCorrectPoints').value = multipleTrue;
  document.getElementById('editMultipleWrongPoints').value = multipleFalse;
  document.getElementById('editComplexCorrectPoints').value = complexTrue;
  document.getElementById('editComplexWrongPoints').value = complexFalse;
  document.getElementById('editMatchCorrectPoints').value = matchTrue;
  document.getElementById('editMatchWrongPoints').value = matchFalse;
}


function updateQuestionBank() {
  const formData = $('#editQuestionBankForm').serialize();

  $.ajax({
    url: `{{ config('app.url') }}/edit-question-bank`,
    type: 'POST',
    data: formData,
    success: function (response) {
      alert('Question Bank updated successfully!');
      location.reload();
    },
    error: function () {
      alert('Error updating question bank. Please try again.');
    }
  });
}
</script>
@endsection
