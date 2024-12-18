    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Welcome, Participant!</h6>
                <p>Here is the schedule for your upcoming exams:</p>
            </div>
            <div class="card-body">
                <div id="">
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

    <script>
    $(document).ready(function () {
        loadExams();
    });

    function loadExams() {
        $.ajax({
            url: '{{ config('app.url') }}/users/exams-data',
            type: 'GET',
            headers: {
                userId: {{ Session::get('user_id') }}
            },
            success: function (response) {
                const tableBody = $('#examsTable tbody');
                tableBody.empty(); // Bersihkan tabel sebelum menambahkan data baru

                if (response.data && response.data.length > 0) {
                    response.data.forEach((data, index) => {
                        const row = `
                            <tr data-id="${index + 1}">
                                <th scope="row">${index + 1}</th>
                                <td>${data.name}</td>
                                <td>${data.date}</td>
                                <td>${data.start_time}</td>
                                <td>${data.end_time}</td>
                                <td>
                                    ${getStatusButton(data.status)}
                                </td>

                            </tr>
                        `;
                        tableBody.append(row);
                    });
                } else {
                    // Tampilkan pesan "Not Found" jika tidak ada data
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

    function getStatusButton(status) {
        if (status === 'Kerjakan') {
            return `<a href="/exam" class="btn btn-success">${status}</a>`;
        } else if (status === 'Waiting') {
            return `<a href="#" class="btn btn-secondary disabled-link" style="pointer-events: none;">${status}</a>`;
        } else {
            return `<a href="#" class="btn btn-danger disabled-link" style="pointer-events: none;">${status}</a>`;
        }
    }

</script>

