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
         .question-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .question-item {
            background: #f4f4f4;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .answer-dropzone {
            background: #e9ecef;
            border: 2px dashed #6c757d;
            border-radius: 5px;
            min-height: 50px;
            padding: 10px;
            margin-top: 10px;
            text-align: center;
            cursor: pointer;
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }
        .modal-option {
            background: #d4edda;
            border: 1px solid #28a745;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .toast.bg-custom {
            background-color: #4caf50; /* Warna hijau kustom */
            color: #fff; /* Teks putih */
        }
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

                        <div class="d-flex justify-content-between align-items-center mt-4"  id ="targetContainer">
                            <!-- Tombol Previous -->

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

<div id="modal" class="modal-overlay">
    <div class="modal-content">
        <h2>Pilih Jawaban</h2>
        <div id="modalOptions"></div>
        <br>    
        <button onclick="closeModal()">Tutup</button>
    </div>
</div>

<div class="toast-container position-fixed top-0 start-0 p-3">
    <div id="toast" class="toast text-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div id="toast-header" class="toast-header text-white">
            <strong class="me-auto" >Message</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div id="toast-body" class="toast-body">
            Pesan akan muncul di sini.
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Akhiri Ujian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mengakhiri ujian?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmFinishBtn">Akhiri</button>
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
    let answer_option = null;
    let essay_answer = null;
    let container = null;
    
    const url = new URL(window.location.href);
    const number = url.searchParams.get('number');
    let questions_first = null;
    let questions_second = null;
    let data = null;
    let answers = null;
    let type = null;
    let total_page = null;    

     $(document).ready(async function() {
        document.querySelector('#nomorSoal').textContent = numberParam;
        data = await fetchData();            
        type = data.type;
        total_page = data.total_page;
        answers = { ...data.answers };
        
        await onLoadPage();
        
        const encryptedId = '{{ $id }}'; 
        navigatePage(total_page);
        checkSizeScreen();
    });

    function navigatePage(total_page){
        const htmlContent = `
        <button class="btn btn-primary" onclick="navigatePush(-1)" id="prevPage" aria-label="Previous Page" ${numberParam <= 1 ? 'disabled' : ''}>
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </button>
            
            <!-- Checkbox untuk Ragu -->
            <div class="form-check">
            <input type="checkbox" class="form-check-input" id="doubt">
            <label class="form-check-label" for="doubt">Ragu</label>
            </div>
            
            <!-- Tombol Next -->
            <button class="btn btn-primary" onclick="navigatePush(1)" id="nextPage" ${numberParam >= total_page ? 'disabled' : ''} aria-label="Next Page">
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </button>
            `;
            document.getElementById('targetContainer').innerHTML = htmlContent; // Ganti `targetContainer` dengan ID elemen target
    }

    function checkSizeScreen(){
        let isAltPressed = false;
        let isPageNavigation = false; 
        const isMobile = window.innerWidth <= 768;
        if (isMobile) {
            console.log('Mobile Screen');
            window.addEventListener('blur', () => {
                console.log('Pengguna meninggalkan jendela browser.');
                updateSessionOut();
                leaveCount++;
                updateLeaveCount();
                sendWebSocket('{{Session::get('username')}}', '{{Session::get('user_id')}}', '{{Session::get('parent_id')}}', 'Detected Out From Exam Page!');
                modal.show(); 
            });
    
            window.addEventListener('focus', () => {
                console.log('Pengguna kembali ke jendela browser.');
            });
        }

        if (!isMobile) {
            document.addEventListener('mouseleave', () => {
                console.log('Windows Screen');
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
                    sendWebSocket('{{Session::get('username')}}', '{{Session::get('user_id')}}', '{{Session::get('parent_id')}}', 'Detected Out From Exam Page!');
                    updateLeaveCount();   
                    isModalVisible = false;
                }
            });
        }
    }

    function fetchData() {
        const url = new URL(window.location.href);
        const number = url.searchParams.get('number');

        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ config('app.url') }}/question-user',
                type: 'GET',
                data: {
                    number: number,
                    user_id: '{{ Session::get("user_id") }}'
                },
                success: function(response) {
                    data = {
                        questions: response.match_question,
                        options: response.option_second,
                        answers: response.match_answer,
                        type : response.type,
                        total_page : response.total_page
                    };
                    
                    resolve(data ); // Resolving the Promise
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    reject(error); // Rejecting the Promise
                }
            });
        });
    }

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }
    function openModal(questionId) {
    
        selectedDropzone = document.querySelector(`.answer-dropzone[data-id="${questionId}"]`);
        const modalOptions = document.getElementById('modalOptions');
        modalOptions.innerHTML = '';

        const shuffledOptions = shuffleArray([...data.options]);
        shuffledOptions.forEach((option) => {
            const optionElement = document.createElement('div');
            optionElement.classList.add('option');
            optionElement.textContent = option.option;
            optionElement.onclick = () => selectAnswer(questionId, option.id);
            
            // Apply styles directly to the div
            optionElement.style.padding = '15px';
            optionElement.style.marginBottom = '8px';
            optionElement.style.borderBottom = '1px solid #ddd';
            optionElement.style.borderRadius = '8px';
            optionElement.style.cursor = 'pointer';
            optionElement.style.backgroundColor = '#f9f9f9';
            optionElement.style.transition = 'background-color 0.3s, transform 0.2s';
            
            // Hover effect
            optionElement.onmouseover = function() {
                optionElement.style.backgroundColor = '#f1f1f1';
                optionElement.style.transform = 'scale(1.05)';
            };
            optionElement.onmouseout = function() {
                optionElement.style.backgroundColor = '#f9f9f9';
                optionElement.style.transform = 'scale(1)';
            };

            modalOptions.appendChild(optionElement);
        });

        document.getElementById('modal').style.display = 'flex';
    }


    function selectAnswer(questionId, optionId) {        
        if (selectedDropzone) {
            selectedDropzone.textContent = data.options.find((opt) => opt.id === optionId).option;
            answers[questionId] = optionId;
        }
        closeModal();
    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }

    function saveAnswers() {
        const allNull = Object.values(answers).every((answer) => answer === null);

        if (allNull) {
            const payload = {
                question: null,
                answer: null
            };
            return payload; // Jika semua null, langsung return null
        }

        // Jika tidak semua null, buat payload seperti biasa
        const questionIds = Object.keys(answers).join(',');
        const answerIds = Object.values(answers)
            .map((answer) => (answer === null ? 'null' : answer)) // Ganti null dengan 'null'
            .join(',');

        const payload = {
            question: questionIds,
            answer: answerIds
        };

        return payload;
    }


    function navigatePush(number){
        saveAnswer(numberParam + (number));
    }
    function getUrlParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    async function onLoadPage() {
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
                        } else if (myData.type == 'match') {
                            fetchQuestion('match');
                            console.log(myData.type);
                            questionHtml = $('#match-template').html();
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
                                questionListHtml += `<a class="btn btn-outline-primary m-1 halaman active" onclick="saveAnswer(${question.number_of})">${question.number_of}</a>`;
                            }else{
                                if(question.status == 1){
                                    questionListHtml += `<a class="btn btn-success halaman m-1" onclick="saveAnswer(${question.number_of})">${question.number_of}</a>`;
                                }else if(question.status == -1){
                                    questionListHtml += `<a class="btn btn-warning halaman m-1" onclick="saveAnswer(${question.number_of})">${question.number_of}</a>`;
                                }else{
                                    questionListHtml += `<a class="btn btn-outline-primary halaman m-1" onclick="saveAnswer(${question.number_of})">${question.number_of}</a>`;
                                }                                
                            }
                            if(total_page == question.number_of){
                                questionListHtml += `<a class="btn btn-danger halaman m-1" onclick="confirmFinishExam(`+{{Session::get('user_id')}}+` , 1);">Finish</a>`;
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

    function confirmFinishExam(user_id, exam_id) {
        // Tampilkan modal konfirmasi
        const modal = document.getElementById('confirmModal');
        const confirmButton = document.getElementById('confirmFinishBtn');

        // Pastikan modal dapat ditampilkan
        modal.style.display = 'block';
        modal.classList.add('show');

        // Ketika tombol "Akhiri" di dalam modal diklik
        confirmButton.onclick = function () {
            finishExam(user_id, exam_id);
            modal.style.display = 'none';
        };
    }

    function finishExam(user_id, exam_id) {
        // Panggil endpoint AJAX
        $.ajax({
            url: '{{ config('app.url') }}/finish',
            type: 'POST',
            data: {
                user_id: user_id,
                exam_id: exam_id
            },
            success: function (response) {
                console.log('Ujian berhasil diakhiri:', response);
                saveAnswer(number , 'finish');
                window.location.href = '/';
            },
            error: function (xhr, status, error) {
                console.error('Gagal mengakhiri ujian:', error);
                alert('Terjadi kesalahan. Coba lagi nanti.');
            }
        });
    }

    // Event untuk menutup modal (jika ada klik di luar modal atau tombol tutup)
    window.onclick = function (event) {
        const modal = document.getElementById('confirmModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    document.querySelector('.close').onclick = function () {
        document.getElementById('confirmModal').style.display = 'none';
    };

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
            question_id = data.id;
            
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
                    radioInput.name = 'jawaban[]';
                    radioInput.id = `jawaban-${option.id}`;
                    radioInput.value = option.id;
                    
                    if (option.id) {
                        answer_option += ','; 
                    }
                    answer_option += option.id;
                    
                    if (data.answer != null) {
                        data.answer.forEach(answer => {
                            if (answer.option_id === option.id) {
                                
                                radioInput.checked = true;
                            }                            
                        });
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
                    if (answer_option) {
                        answer_option += ','; 
                    }
                    answer_option += option.id;
                    const optionDiv = document.createElement('div');
                    optionDiv.classList.add('form-check');

                    const checkboxInput = document.createElement('input');
                    checkboxInput.classList.add('form-check-input');
                    checkboxInput.type = 'checkbox';
                    checkboxInput.name = 'jawaban[]';
                    checkboxInput.id = `jawaban-${option.id}`;
                    checkboxInput.value = option.id;

                    if (data.answer != null) {
                        data.answer.forEach(answer => {
                            if (answer.option_id === option.id) {
                                checkboxInput.checked = true;
                            }
                            if (answer_option) {
                                answer_option += ','; 
                            }
                            answer_option += answer.option_id;
                        });
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
                $('#essay').val(data.answer);
                essay_answer = data.answer;
            } else if (type == 'match'){
                displayQuestions();

            }
            
        } catch (error) {
            console.error('Error fetching question data:', error);
        }
    }

    function saveAnswer(number , finish = null) {
        let matchPayload = null;
        if(type == 'match'){
            matchPayload = saveAnswers();
        }
        


        const toast = new bootstrap.Toast(document.getElementById('toast'));
        const toastBody = document.getElementById('toast-body');
        const toastHeader = document.getElementById('toast-header');
        const jawabanElements = document.getElementsByName('jawaban[]');
        const essayElements = document.getElementById('essay')?.value ?? null;
        const doubt = document.getElementById('doubt').checked ? 1 : 0;

        const checkedValues = Array.from(jawabanElements)
            .filter(input => input.checked) // Hanya elemen yang checked
            .map(input => input.value)     // Ambil nilai value
            .join(",");   
                                

        
            const data = {
                question_id: question_id, // ID pertanyaan
                answer: checkedValues ? checkedValues : null, // Jika checkedValues tidak undefined/kosong, gunakan nilainya; jika tidak, null
                user_id: '{{Session::get('user_id')}}', // ID pengguna dari session
                essay: essayElements ? essayElements : null,
                doubt: doubt, // Jika essayElements tidak undefined/kosong, gunakan nilainya; jika tidak, null
            };
            
            if (type === 'match') {
                delete data.answer;
                data.answer = matchPayload['answer'];
            }
            
        $.ajax({
            url: '{{ config('app.url') }}/save-answer', // URL tujuan
            type: 'POST',
            data: data,
            success: function (result) {
                // Jika berhasil
                toastBody.classList.remove('bg-danger');
                toastHeader.classList.add('bg-success');
                toastBody.classList.add('bg-success');
                toastBody.innerHTML = result.message;
                toast.show();

                // Redirect setelah delay
                if(!finish){
                    setTimeout(() => {
                        window.location.href = `?number=${number}`;
                    }, 100);
                }
            },
            error: function (xhr, status, error) {
                // Jika gagal
                console.error(error);
                toastBody.classList.remove('bg-success');
                toastHeader.classList.add('bg-danger');
                toastBody.classList.add('bg-danger');
                toastBody.innerHTML = `
                    Gagal Simpan, Klik next untuk lanjut 
                    <br>
                    <button class="btn btn-sm btn-primary text-white mt-2" id="continue" style="font-size:10px;">Next</button>
                `;
                toast.show();

                // Event listener untuk tombol "Lanjutkan"
                $(document).on('click', '#continue', function () {
                    toast.hide();
                    window.location.href = `?number=${number}`; // Lanjutkan meskipun gagal
                });
            }
        });
    }

    function displayQuestions() {
        const container = document.getElementById('questionContainer');
        
        if (!container) {
            console.error('Container element with ID "questionContainer" not found.');
            return;
        }

        if (!data || !data.questions || data.questions.length === 0) {
            console.error('No questions found in data.');
            return;
        }

        data.questions.forEach((question) => {
            const questionElement = document.createElement('div');
            questionElement.classList.add('question-item');

            const answerId = answers[question.id];

            const answerText = answerId
                ? data.options.find((option) => option.id === answerId)?.option
                : 'Klik untuk memilih';

            container.innerHTML += `
                <div class="question-item">
                    <p>${question.question}</p>
                    <div class="answer-dropzone" data-id="${question.id}" onclick="openModal(${question.id})">${answerText}</div>
                </div>
            `;
        });
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

    function sendWebSocket(username, userId, targetUserId, message) {
        const ws = new WebSocket('{{ config('app.websocket') }}');

        ws.onopen = () => {
            console.log('Connected to WebSocket server');

            const payload = {
                user_id: userId, // ID pengirim
                target_user_id: targetUserId, // ID penerima
                username: username, // Nama pengguna pengirim
                message: message, // Pesan yang dikirim
                time: new Date().toLocaleTimeString() // Waktu pengiriman
            };

            // console.log(`Sending message: ${JSON.stringify(payload)}`);
            ws.send(JSON.stringify(payload)); // Kirim payload setelah koneksi terbuka
        };

        ws.onerror = (error) => {
            console.error(`WebSocket Error: ${error}`);
        };

        ws.onclose = () => {
            console.log('WebSocket connection closed');
        };
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
<script type="text/template" id="match-template">
    <div>
    @include('client.users.type.match')
    </div>
</script>



</html>
