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
                        <span class="badge bg-primary timer-text">
                            2
                        </span>
                    </div>                    
                    <div class="text-end">
                        <span class="badge bg-primary p-2 p-sm-3 timer-text">
                            Sisa Waktu: 01:59:21
                        </span>                    
                    </div>
                </div>


                <!-- Question Section -->
                <div class="row" style="user-select: none; -webkit-user-select: none; -ms-user-select: none;">
                <div class="col-md-8 container">
                    <div class="card p-3">
                        <!-- Soal -->
                        <p>Seorang peternak menetaskan telur ayam menggunakan lampu bohlam. Pada peristiwa ini terjadi perpindahan kalor secara ....</p>

                        <!-- Pilihan Jawaban -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban1">
                            <label class="form-check-label" for="jawaban1">Konduksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2">
                            <label class="form-check-label" for="jawaban2">Konveksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban3">
                            <label class="form-check-label" for="jawaban3">Radiasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban4">
                            <label class="form-check-label" for="jawaban4">Isolasi</label>
                        </div>

                        <!-- Tombol Navigasi -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <!-- Tombol Previous -->
                            <button class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i>
                            </button>

                            <!-- Tombol Ragu -->
                            <div class="d-flex align-items-center">
                                <button class="btn btn-warning text-white me-2" id="raguButton">Ragu</button>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="raguCheckbox">
                                    <label class="form-check-label" for="raguCheckbox"></label>
                                </div>
                            </div>

                            <!-- Tombol Next -->
                            <button class="btn btn-primary">
                                    <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                    <!-- Navigation Section -->
                    <div class="col-md-4 pt-3">
                        <h6>Nomor Soal</h6>
                        <div class="question-nav d-flex flex-wrap">
                            <button class="btn btn-outline-primary m-1">1</button>
                            <button class="btn btn-primary m-1">2</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">1</button>
                            <button class="btn btn-outline-primary m-1">2</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>
                            <button class="btn btn-outline-primary m-1">3</button>                            
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda telah terdeteksi meninggalkan layar. Pastikan tetap fokus pada ujian!
                <br><b>Jika belum kembali dalam waktu 30 detik sudah ditentukan ujian anda dianggap selesai </b>
                <br>
                <i class="font-weight-bold text-danger" id="countdown"></i>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Kembali ke Ujian</button>
            </div>
        </div>
    </div>
</div>
<!-- <audio id="leaveAudio" src="../mp3/leave-sound.mp3" loop></audio> -->

<script>
    const leaveAudio = document.getElementById('leaveAudio'); 
    const modal = new bootstrap.Modal(document.getElementById('mouseleaveModal'));
    let isModalVisible = false; 
    const countdownElement = document.getElementById('countdown'); 

    document.addEventListener('mouseleave', () => {
        if (!isModalVisible) { 
            leaveAudio.play(); 
            modal.show(); 
            isModalVisible = true;
        }
    });

    modal._element.addEventListener('hidden.bs.modal', () => {
        isModalVisible = false;
        leaveAudio.pause();
        leaveAudio.currentTime = 0;
    });

    document.addEventListener('mouseenter', () => {
        if (isModalVisible) {
            modal.hide();
            leaveAudio.pause();
            leaveAudio.currentTime = 0;
            isModalVisible = false;
        }
    });

    const raguButton = document.getElementById('raguButton');
    const raguCheckbox = document.getElementById('raguCheckbox');

    raguButton.addEventListener('click', function () {
        if (raguCheckbox.checked) {
            raguCheckbox.checked = false;
            raguButton.textContent = 'Ragu';
            raguButton.classList.remove('btn-danger');
            raguButton.classList.add('btn-warning', 'text-white');
        } else {
            raguCheckbox.checked = true;
            raguButton.textContent = 'Tidak Ragu';
            raguButton.classList.remove('btn-warning', 'text-white');
            raguButton.classList.add('btn-danger');
        }
    });

    raguCheckbox.addEventListener('change', function () {
        if (raguCheckbox.checked) {
            raguButton.textContent = 'Tidak Ragu';
            raguButton.classList.remove('btn-warning', 'text-white');
            raguButton.classList.add('btn-danger');
        } else {
            raguButton.textContent = 'Ragu';
            raguButton.classList.remove('btn-danger');
            raguButton.classList.add('btn-warning', 'text-white');
        }
    });

    
</script>
</html>
