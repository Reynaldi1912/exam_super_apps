@extends('app')
@section('content')
@php
    $menus_name = 'Results Exam'
@endphp

    <div class="col-xl-12 pt-5">
        <table class="table table-striped" id="results">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Question Name</th>
                <th scope="col">Answers</th>
                <th scope="col">Poin</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ibu Kota Indonesia</td>
                    <td>
                        <ul class="list-unstyled">
                            <li class="text-success"><b>Jakarta</b></li>
                            <li>Makasar</li>
                            <li>Suarabaya</li>
                            <li>Bali</li>
                        </ul>
                    </td>
                    <td>2</td>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="number" class="form-control" style="margin-right: 8px;width:100px;">
                            <button class="btn btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
@endsection