@extends('app')
@section('content')
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div id="grouping" class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Grouping User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Expired</div>
                    </div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Limit Exam
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div id="limit_exam" class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Expired</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total User <a href="#" class="text-danger text-bold">( - Deactive )</a>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div id="limit_user" class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Expired</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: 12%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2" data-toggle="modal" data-target="#updateTokenModal">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Expired Account 
                        <a href="#" class="text-danger text-bold"></a>
                    </div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="expired_account">Expired</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    style="width: 12%" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Content Column -->
    <div class="col-lg-12 mb-4"  id="dashboardCard" style="display: none;">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <select name="" id="" class="form-control">
                <option value="">UJIAN TENGAH SEMESTER - 
                    <span id="examStatus">07:00 - 08:00 / 20 December 2024</span>
                </option>
            </select>

            <p id="examStatusText" class="pt-3">Exam Status: <span id="examStatusLabel">Loading...</span></p>

                <h6 class="m-0 font-weight-bold text-dark pb-2 mt-4">Choosed Exam : <span class="font-weight-bold text-primary">UJIAN TENGAH SEMESTER</span></h6>
                <span class="text-primary font-weight-bold">07:00 - 08:00 | 20 December 2024</span>
            </div>
            <div class="card-body">
                <h4 class="small text-danger">Kelas 7A<span
                        class="float-right">20%</span> - <span class="text-danger font-weight-bold">WAITING</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small text-warning">Kelas 7B - <span class="text-warning font-weight-bold">RUNNING</span><span
                        class="float-right">40%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 40%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h4 class="small text-success">Kelas 8B <span
                        class="float-right">100%</span> - <span class="font-weight-bold text-success"><i>DONE</i></span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12 mb-4"  id="dashboardReminder" style="display: none;">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5><b>STATUS AKUN ANDA : </b></h5>
                <p class="text-danger">Limit akun anda telah habis, silahkan hubungi admin untuk melakukan perpanjangan ke <a href="https://wa.me/6285745785615">085745785615</a></p>
            </div>
        </div>
    </div>



    <div class="modal fade" id="updateTokenModal" tabindex="-1" role="dialog" aria-labelledby="updateTokenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTokenModalLabel">Update Token</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="newToken">Token</label>
                            <input type="text" class="form-control" id="newToken" placeholder="Enter new token">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="updateToken()">Update Token</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>           
            $(document).ready(function() {
                $.ajax({
                    url: '{{ config('app.url') }}/get-dashboard',
                    type: 'GET',
                    headers: {
                        Authorization: "Bearer " + '{{Session::get('token_user')}}',
                        UserId: {{Session::get('user_id')}}
                    },
                    success: function(response) {                        
                        if (response.success) {
                            $('.text-primary.text-uppercase.mb-1').eq(0).text('Grouping User');
                            $('.text-gray-800').eq(0).text(0 + ' Group');

                            $('.text-primary.text-uppercase.mb-1').eq(1).text('Limit Exam');
                            $('#limit_exam').text(response.data.total_exam +" / "+response.data.limit_exam);

                            $('.text-primary.text-uppercase.mb-1').eq(2).text('Total User (3 Deactive)');
                            $('#limit_user').text(response.data.total_user +" / "+response.data.limit_user);

                            $('.text-danger.text-uppercase.mb-1').text('Expired Account');
                            var expiredAt = new Date(response.data.expired_at);
                            $('#expired_account').text(expiredAt.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));

                            $('#dashboardCard').show(); // Hide the card if success is false
                            $('#dashboardReminder').hide(); // Hide the card if success is false

                            const examStartTime = new Date('2024-12-20T07:00:00');
                            const examEndTime = new Date('2024-12-20T08:00:00');
                            const currentTime = new Date();

                            const examStatusSpan = document.getElementById('examStatus');
                            const examStatusLabel = document.getElementById('examStatusLabel');

                            if (currentTime < examStartTime) {
                                examStatusSpan.classList.remove('text-warning', 'text-success');
                                examStatusSpan.classList.add('text-danger');
                                examStatusLabel.innerHTML = 'Not started yet';
                            } else if (currentTime >= examStartTime && currentTime <= examEndTime) {
                                examStatusSpan.classList.remove('text-danger', 'text-success');
                                examStatusSpan.classList.add('text-warning');
                                examStatusLabel.innerHTML = 'Running now';
                            } else {
                                examStatusSpan.classList.remove('text-danger', 'text-warning');
                                examStatusSpan.classList.add('text-success');
                                examStatusLabel.innerHTML = 'Done';
                            }

                        } else {
                            // Hide the entire card if success is false
                            $('#dashboardCard').hide();
                            $('#dashboardReminder').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });


            function updateToken() {
                $.ajax({
                    url: '{{ config('app.url') }}/updateToken',
                    type: "POST",
                    contentType: "application/x-www-form-urlencoded",
                    headers: {
                        Authorization: "Bearer " + '{{ Session::get('token_user') }}',
                        UserId: {{ Session::get('user_id') }}
                    },
                    data: {
                        id: {{ Session::get('user_id') }},
                        new_token: $('#newToken').val()
                    },
                    success: function(response) {
                        console.log('Response from server:', response);
                        if (response.success) {
                            $.ajax({
                                url: '/updateSessionToken'  , // Endpoint untuk update session token
                                type: "GET",
                                headers: {
                                    Authorization: "Bearer " + '{{Session::get('token_user')}}',
                                    UserId: {{Session::get('user_id')}}
                                },
                                data: {
                                    new_token: $('#newToken').val() // Kirimkan token baru untuk update session
                                },
                                success: function(updateResponse) {
                                    console.log('Session token updated:', updateResponse);
                                    window.location.reload();
                                },
                                error: function(xhr, status, error) {
                                    console.error('Failed to update session:', xhr.responseJSON.message);
                                    toastMessage.textContent =  xhr.responseJSON.message;
                                    toastElement.classList.remove('text-bg-primary');
                                    toastElement.classList.add('bg-danger');
                                    toast.show();
                                }
                            });
                        } else {
                            // Tangani jika respons tidak berhasil (response.success false)
                            console.error('Failed to update token:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            }

    </script>
@endsection