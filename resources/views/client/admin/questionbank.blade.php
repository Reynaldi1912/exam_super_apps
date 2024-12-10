@extends('app')
@section('content')


<div class="row">
    <!-- Section Kartu Jenis Soal -->
    <div class="col-12 d-flex flex-wrap mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Multiple Choice</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10 Questions</div>
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
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Complex Multiple Choice</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10 Questions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Essay</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10 Questions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Match</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">10 Questions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <!-- Kolom Kiri (Editor) -->
            <div class="col-md-8">
                <div id="summernote"></div>
                <hr class="mt-4">
                <h4 class="mt-4 mb-4 font-weight-bold text-primary">Answer / Option</h4>
                <div class="row">
                    <div class="col">
                        <select id="question_type" class="form-control">
                            <option value="multiple choice">Multiple Choice</option>
                            <option value="complex multiple choice">Complex Multiple Choice</option>
                            <option value="essay">Essay</option>
                            <option value="match">Match</option>
                        </select>
                    </div>
                    <div class="col text-right">
                        <button id="add_option" class="btn btn-success"><i class="fa fa-plus"></i> Add Option</button>
                    </div>
                </div>

                <hr class="mb-3">

                <div id="options_container" class="my-3"></div>

                <a id="submit_button" class="btn btn-primary btn-block">
                    SUBMIT
                </a>
            </div>

            <!-- Kolom Kanan (List Soal) -->
            <div class="col-md-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        Soal 1 <sup class="font-weight-bold text-danger">Multiple Choice</sup>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Soal 2 <sup class="font-weight-bold text-primary">Complex Multiple Choice</sup>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Soal 3 <sup class="font-weight-bold text-warning">Essay</sup>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        Soal 4 <sup class="font-weight-bold text-success">Match</sup>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        limit = 5;
        // Initialize Summernote
        $('#summernote').summernote({
            placeholder: 'Create your question here...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Event listener for question type change
        $('#question_type').on('change', function () {
            const questionType = $(this).val();
            const optionsContainer = $('#options_container');
            optionsContainer.empty();

            if (questionType === 'essay' || questionType === 'match') {
                optionsContainer.append('<p class="text-muted">No options needed for ' + questionType + '.</p>');
            } else {
                addOption(questionType);
            }
        });

        // Add option button click event
        $('#add_option').on('click', function (e) {
            e.preventDefault();
            const questionType = $('#question_type').val();
            const optionsContainer = $('#options_container');
            if ((optionsContainer.children().length < limit) && (questionType !== 'essay' && questionType !== 'match')) {
                addOption(questionType);
            } else if (optionsContainer.children().length >= limit) {
                alert('You can add only 5 options.');
            }
        });

        // Function to dynamically add an option
        function addOption(type) {
            const inputType = type === 'multiple choice' ? 'radio' : 'checkbox';
            const optionsContainer = $('#options_container');
            const optionHtml = `
                <div class="row align-items-center mb-3">
                    <div class="col-10">
                        <textarea name="text_option" class="form-control" rows="2" required placeholder="Enter option text here"></textarea>
                    </div>
                    <div class="col-1 text-center mr-2">
                        <input type="${inputType}" name="option[]" class="form-check-input form-check-lg">
                        <label></label>
                    </div>
                </div>
            `;
            optionsContainer.append(optionHtml);
        }

        // AJAX Post function
        $('#submit_button').on('click', function (e) {
            e.preventDefault();

            const questionData = {
                question: $('#summernote').val(),
                type: $('#question_type').val(),
                options: []
            };

            $('#options_container textarea').each(function (index) {
                const optionText = $(this).val();
                const isChecked = $(this).parent().siblings().find('input').is(':checked');
                questionData.options.push({
                    text: optionText,
                    correct: isChecked
                });
            });

            $.ajax({
                url: '/save-question',
                method: 'POST',
                data: questionData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alert('Question saved successfully!');
                },
                error: function (error) {
                    alert('Error saving question.');
                }
            });
        });
    });
</script>

<style>
    .form-check-lg {
        width: 25px;
        height: 25px;
    }
    .form-control {
        margin-bottom: 0; /* Remove bottom margin from textarea */
    }

    .form-check-input {
        margin-left: 10px; /* Space between checkbox/radio and textarea */
        margin-top: 0; /* Adjust vertical positioning */
    }
</style>

@endsection
