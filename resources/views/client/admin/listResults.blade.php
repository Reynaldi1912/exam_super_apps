@extends('app')
@section('content')
@php
    $menus_name = 'Results Exam'
@endphp
    <div class="col-xl-12">
        <select name="" id="" class="form-control">
            <option value="">Ujian A</option>
            <option value="">Ujian B</option>
            <option value="">Ujian C</option>
        </select>
    </div>

    <div class="col-xl-12 pt-5">
        <table class="table table-striped" id="results">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Username</th>
                <th scope="col">Grouping</th>
                <th scope="col">Time Start</th>
                <th scope="col">Time End</th>
                <th scope="col">Final Poin</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>akbar</td>
                    <td>KELAS 7A</td>
                    <td>08:01:00</td>
                    <td>09:58:00</td>
                    <td>79</td>
                    <td>
                        <a href="/results" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection