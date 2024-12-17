@extends('app')
@section('content')

@if(Session::get('role') == 'peserta')
    <!-- Dashboard for Participant -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Welcome, Participant!</h6>
                <p>Here is the schedule for your upcoming exams:</p>
            </div>
            <div class="card-body">
                <div id="examList">
                    <!-- Exam list will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            loadParticipantDashboard();
        });

        function loadParticipantDashboard() {
            $.ajax({
                url: '{{ config('app.url') }}/get-participant-dashboard',
                type: 'GET',
                headers: {
                    Authorization: "Bearer " + '{{ Session::get('token_user') }}',
                    UserId: {{ Session::get('user_id') }}
                },
                success: function (response) {
                    if (response.success) {
                        let examListHtml = '';
                        response.data.exams.forEach(exam => {
                            examListHtml += `
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">${exam.name}</h5>
                                        <p class="card-text">
                                            Date: ${exam.date}<br>
                                            Time: ${exam.start_time} - ${exam.end_time}
                                        </p>
                                    </div>
                                </div>
                            `;
                        });

                        $('#examList').html(examListHtml);
                    } else {
                        $('#examList').html('<p class="text-danger">No exams found for you.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    $('#examList').html('<p class="text-danger">Failed to load exams. Please try again later.</p>');
                }
            });
        }
    </script>
@else
    <!-- Redirect to 404 or Display Access Denied -->
    <div class="col-lg-12">
        <div class="alert alert-danger" role="alert">
            Access Denied! You are not authorized to view this page.
        </div>
    </div>
@endif

@endsection
