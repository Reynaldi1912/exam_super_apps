<div class="col-lg-12 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-dark">Welcome, Participant!</h6>
            <p>Here is the schedule for your upcoming exams:</p>
        </div>
        <div class="card-body">
            <div class="">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="examsTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">EXAM</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">START</th>
                                    <th scope="col">END</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Confirmation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to start this exam?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a id="confirmStartExam" onclick='execute();' class="btn btn-primary">Start Exam</a>
            </div>
        </div>
    </div>
</div>


    <script>
    id_exam = '';
    end_date_exam = '';
    $(document).ready(function () {
        loadExams();
    });

    function loadExams() {
        $.ajax({
            url: '{{ config("app.url") }}/users/exams-data',
            type: 'GET',
            headers: {
                userId: {{ Session::get('user_id') }}
            },
            success: function (response) {
                const tableBody = $('#examsTable tbody');
                tableBody.empty(); // Clear the table before adding new data

                if (response.data && response.data.length > 0) {
                    response.data.forEach((data, index) => {
                        const row = `
                            <tr>
                                <th scope="row">${index + 1}</th>
                                <td>${data.name}</td>
                                <td>${data.date}</td>
                                <td>${data.start_time}</td>
                                <td>${data.end_time}</td>
                                <td>
                                    ${getStatusButton(data.status, data.id , data.end_date)}
                                </td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });
                } else {
                    const notFoundRow = `
                        <tr>
                            <td colspan="6" class="text-center">No exams found</td>
                        </tr>
                    `;
                    tableBody.append(notFoundRow);
                }
            },
            error: function () {
                alert('Error loading exams. Please try again.');
            }
        });
    }

    function getStatusButton(status, id , expired) {
        if (status === 'Kerjakan') {
            return `<button type="button" class="btn btn-success" onclick="showConfirmationModal(${id} , '${expired}')">${status}</button>`;
        } else if (status === 'Waiting') {
            return `<a href="#" class="btn btn-secondary disabled-link" style="pointer-events: none;">${status}</a>`;
        } else {
            return `<a href="#" class="btn btn-danger disabled-link" style="pointer-events: none;">${status}</a>`;
        }
    }

    function showConfirmationModal(id , end_date) {
        const modal = $('#confirmationModal');
        id_exam = id;
        end_date_exam = end_date;

        console.log(id_exam);
        console.log(end_date_exam);
        
        
        modal.modal('show');
    }
    function execute(){
        const confirmButton = $('#confirmStartExam');

        $.ajax({
            url: '/set-exam-session', 
            type: 'GET',
            data: {
                exam_id: id_exam,
                end_date : end_date_exam
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                const modal = $('#confirmationModal');
                const confirmButton = $('#confirmStartExam');
                
                confirmButton.attr('href', `/exam/${id}?number=1`);
                
                modal.modal('show');
            },
            error: function () {
                alert('Failed to set exam session. Please try again.');
            }
        });
        confirmButton.attr('href', `/exam/${id_exam}?number=1`);
    }
</script>

