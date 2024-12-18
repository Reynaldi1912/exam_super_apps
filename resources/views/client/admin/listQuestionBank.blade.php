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
              <!-- Redirect to Question Bank page -->
              <a href="/question-bank/${data.id}" class="btn btn-primary btn-sm">Go to Question Bank</a>
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
</script>
@endsection
