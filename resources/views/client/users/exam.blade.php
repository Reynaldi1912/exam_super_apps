<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .screenshot-protect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.001); /* Transparan */
            pointer-events: none; /* Jangan ganggu interaksi */
            z-index: 9999;
        }

        body {
            font-family: Arial, sans-serif;
            backdrop-filter: blur(10px);
        }
        .sidebar {
            background-color: #4263eb;
            height: 100vh;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .question-box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }
        .sticky-footer {
            position: sticky;
            bottom: 0;
            background-color: white;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.1);
        }
        .question-nav {
            max-height: 400px;
            overflow-y: auto;
        }
        .timer-text {
            font-size: 10px; /* Default font size for mobile */
        }

        @media (min-width: 576px) {
            .timer-text {
                font-size: 24px; /* Font size for tablets and up */
            }
        }

        @media (min-width: 768px) {
            .timer-text {
                font-size: 30px; /* Font size for larger screens */
            }
        }
        .d-flex {
            align-items: center; /* Align the items in the center */
        }

        .badge {
            font-size: inherit; /* Make sure the font size is inherited */
            padding: 0.5rem 1rem; /* Add padding to badges to make them aligned */
        }

        .text-end {
            display: flex;
            align-items: center; /* Vertically center the timer */
        }
    </style>
</head>
<body>

<div class="screenshot-protect"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-12 col-lg-12 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="timer-text">
                        No Soal.
                        <span class="badge bg-primary timer-text" id="nomorSoal">
                            -
                        </span>
                    </div>                    
                    <div class="text-end">
                        <span class="badge bg-primary p-2 p-sm-3 timer-text">
                            Sisa Waktu: 01:59:21
                        </span>  
                        <span class="badge bg-danger p-2 p-sm-3 timer-text" id="leaveCount">
                            {{Session::get('out')}}
                        </span>
                    </div>
                </div>


                <!-- Question Section -->
                <div class="row" style="user-select: none; -webkit-user-select: none; -ms-user-select: none;">
                    <div class="col-md-8" >
                        <div id="question_id">
                            
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <!-- Tombol Previous -->
                            <a class="btn btn-primary" id="prevPage">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <a class="btn btn-primary" id="nextPage">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                  

                    <!-- Navigation Section -->
                    <div class="col-md-4 pt-3">
                        <h6>Nomor Soal</h6>
                        <div class="question-nav d-flex flex-wrap" id="question-list">
                                           
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<div class="modal fade" id="mouseleaveModal" tabindex="-1" aria-labelledby="mouseleaveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mouseleaveModalLabel">Peringatan</h5>
            </div>
            <div class="modal-body">
                Anda telah terdeteksi meninggalkan layar. Pastikan tetap fokus pada ujian!
                <br></b>
                <br>
                <i class="font-weight-bold text-danger" id="countdown"></i>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali ke Ujian</button>
            </div>
        </div>
    </div>
</div>

<script>
    const numberParam = parseInt(getUrlParameter('number')); 
    const leaveAudio = document.getElementById('leaveAudio'); 
    const modal = new bootstrap.Modal(document.getElementById('mouseleaveModal'));
    const countdownElement = document.getElementById('countdown'); 
    let isModalVisible = false;
    let leaveCount = '{{Session::get('out')}}';

    $(document).ready(async function() {
        document.querySelector('#nomorSoal').textContent = numberParam;
        await onLoadPage();
        const encryptedId = '{{ $id }}'; 
        
        document.querySelector('#nextPage').href = `/exam/${encryptedId}?number=${numberParam + 1}`;
        document.querySelector('#prevPage').href = `/exam/${encryptedId}?number=${numberParam - 1}`;
        let isAltPressed = false;
        let isPageNavigation = false; 
        const isMobile = window.innerWidth <= 768;

        
        if (isMobile) {
            console.log('ismobile');
            window.addEventListener('blur', () => {
                console.log('Pengguna meninggalkan jendela browser.');
                updateSessionOut();
                leaveCount++;
                updateLeaveCount();
                modal.show(); 
            });
    
            window.addEventListener('focus', () => {
                console.log('Pengguna kembali ke jendela browser.');
            });
    
            document.querySelectorAll('#prevPage, #nextPage, .halaman').forEach(button => {
                button.addEventListener('click', () => {
                    isPageNavigation = true;
                });
            });
        }

        if (!isMobile) {
            document.addEventListener('mouseleave', () => {
                console.log('windows');
                if (!isModalVisible) { 
                    modal.show();       
                    isModalVisible = true;
                }
            });
            
            modal._element.addEventListener('hidden.bs.modal', () => {
                isModalVisible = false;
            });
            
            document.addEventListener('mouseenter', () => {
                if (isModalVisible) {
                    updateSessionOut(); 
                    leaveCount++;
                    updateLeaveCount();   
                    isModalVisible = false;
                }
            });
        }
    });


    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    function onLoadPage() {
        if (numberParam) {
            $.ajax({
                url: '{{ config('app.url') }}/number-of-exam?id=1&number=' + numberParam+ '&user_id={{Session::get('user_id')}}',
                method: "GET",
                success: function(response) {
                    
                    const myData = response.data.find(item => item.number_of == numberParam);

                    if (myData) {
                        let questionHtml = '';

                        if (myData.type == 'multiple') {
                            console.log('multiple');
                            fetchQuestion('multiple');
                            questionHtml = $('#multiple-template').html();
                        } else if (myData.type == 'complex') {
                            console.log('complex');
                            fetchQuestion('complex');
                            questionHtml = $('#complex-template').html();
                        } else if (myData.type == 'essay') {
                            fetchQuestion('essay');
                            questionHtml = $('#essay-template').html();
                        }

                        if (questionHtml) {
                            $('#question_id').html('<div class="question-box">' + questionHtml + '</div>');
                        }
                    }

                    if (response.success) {
                        let questions = response.data;
                        let questionListHtml = "";

                        questions.forEach(function (question) {
                            if(numberParam == question.number_of){
                                questionListHtml += `<a href="?number=${question.number_of}" class="btn btn-outline-primary m-1 halaman active">${question.number_of}</a>`;
                            }else{
                                questionListHtml += `<a href="?number=${question.number_of}" class="btn btn-outline-primary halaman m-1">${question.number_of}</a>`;
                            }
                        });

                        $("#question-list").html(questionListHtml);
                    } else {
                        console.log("Failed to retrieve questions");
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error fetching data: ", error);
                }
            });
        } else {
            console.log("No 'number' parameter found in the URL.");
        }
    }

    async function fetchQuestion(type) {
    try {
        const numberParam = getUrlParameter('number');

        
        if (!numberParam) {
            console.error("No 'number' parameter found in the URL.");
            return;
        }
        
        const response = await fetch('{{ config('app.url') }}/question-user?number=' + numberParam + '&user_id={{Session::get('user_id')}}');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        const questionTextElement = document.getElementById('question-text');
        questionTextElement.textContent = data.question;
                        
        if (type === 'multiple') {
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';

            data.options.forEach(option => {
                const optionDiv = document.createElement('div');
                optionDiv.classList.add('form-check');

                const radioInput = document.createElement('input');
                radioInput.classList.add('form-check-input');
                radioInput.type = 'radio';
                radioInput.name = 'jawaban';
                radioInput.id = `jawaban-${option.id}`;
                radioInput.value = option.id;

                if (data.answer.some(answer => answer.option_id === option.id)) {
                    radioInput.checked = true;
                }

                const label = document.createElement('label');
                label.classList.add('form-check-label');
                label.setAttribute('for', `jawaban-${option.id}`);
                label.textContent = option.text;

                optionDiv.appendChild(radioInput);
                optionDiv.appendChild(label);
                optionsContainer.appendChild(optionDiv);
            });
        } else if (type === 'complex') {
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';
            data.options.forEach(option => {
                const optionDiv = document.createElement('div');
                optionDiv.classList.add('form-check');

                const checkboxInput = document.createElement('input');
                checkboxInput.classList.add('form-check-input');
                checkboxInput.type = 'checkbox';
                checkboxInput.name = 'jawaban';
                checkboxInput.id = `jawaban-${option.id}`;
                checkboxInput.value = option.id;

                if (data.answer.some(answer => answer.option_id === option.id)) {
                    checkboxInput.checked = true;
                }

                const label = document.createElement('label');
                label.classList.add('form-check-label');
                label.setAttribute('for', `jawaban-${option.id}`);
                label.textContent = option.text;

                optionDiv.appendChild(checkboxInput);
                optionDiv.appendChild(label);
                optionsContainer.appendChild(optionDiv);
            });
        } else if (type === 'essay') {
            $('#jawaban').val(data.answer);
        }

        

    } catch (error) {
        console.error('Error fetching question data:', error);
    }
}


     function updateSessionOut() {
            fetch('/update-session-on-exam', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Sesi berhasil diperbarui.');
                } else {
                    console.error('Gagal memperbarui sesi.');
                }
            })
            .catch(error => {
                console.error('Kesalahan saat memperbarui sesi:', error);
            });
        }

        function updateLeaveCount() {
            document.getElementById('leaveCount').textContent = leaveCount;
        }
</script>

<script type="text/template" id="multiple-template">
    <div>
    @include('client.users.type.multiple')
    </div>
</script>

<script type="text/template" id="complex-template">
    <div>
    @include('client.users.type.complex')
    </div>
</script>

<script type="text/template" id="essay-template">
    <div>
    @include('client.users.type.essay')
    </div>
</script>




</html>
