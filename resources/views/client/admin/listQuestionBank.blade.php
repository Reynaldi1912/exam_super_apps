@extends('app')

@section('content')
<!-- Bank Soal Table -->
<div class="container-fluid mt-5">
  <h2 class="mb-4">Bank Soal</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Nama Bank Soal</th>
        <th scope="col">Jumlah Soal</th>
        <th scope="col">Poin Per Tipe</th>
        <th scope="col">Poin Salah</th>
        <th scope="col">Exams</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Bank Soal Matematika</td>
        <td>
          <ul>
            <li><span class="text-danger">Multiple Choice: 10 Soal</span></li>
            <li><span class="text-primary">Complex Multiple Choice: 20 Soal</span></li>
            <li><span class="text-warning">Essay: 5 Soal</span></li>
            <li><span class="text-success">Match: 10 Soal</span></li>
          </ul>
        </td>
        <td>
          <ul>
            <li><span class="text-danger">Multiple Choice: 2 Poin</span></li>
            <li><span class="text-primary">Complex Multiple Choice: 3 Poin</span></li>
            <li><span class="text-warning">Essay: 5 Poin</span></li>
            <li><span class="text-success">Match: 4 Poin</span></li>
          </ul>
        </td>
        <td>
          <ul>
            <li><span class="text-danger">Multiple Choice: -1 Poin</span></li>
            <li><span class="text-primary">Complex Multiple Choice: -2 Poin</span></li>
            <li><span class="text-warning">Essay: -3 Poin</span></li>
            <li><span class="text-success">Match: -2 Poin</span></li>
          </ul>
        </td>
        <td>
          <ul>
            <li><span class="text-danger">Matematika Ujian 1</span></li>
            <li><span class="text-primary">Matematika Ujian 2</span></li>
          </ul>
        </td>
        <td>
          <!-- Redirect to Question Bank page -->
          <a href="/question-bank/1" class="btn btn-primary">Go to Question Bank</a>
        </td>
      </tr>
      <!-- Additional Bank Soal can be added here -->
    </tbody>
  </table>
</div>
@endsection
