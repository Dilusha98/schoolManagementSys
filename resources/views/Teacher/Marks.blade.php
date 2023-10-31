@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'teacher')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('Teacher.Tlayout')

@section('title')
    Marks
@endsection

@section('content')
    <div class="card">
        <input type="text" id="subid" hidden>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semOne" aria-controls="navs-top-semOne" aria-selected="true">Semester
                    One</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semTwo" aria-controls="navs-top-semTwo" aria-selected="false">Semester
                    Two</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-semThee" aria-controls="navs-top-semThee" aria-selected="false">Semester
                    Three</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-semOne" role="tabpanel">
                <div class="row container">
                    <div class="col-md-6">
                        @if ($subjects !== 'null' || $subjects->count() > 0)
                            @foreach ($subjects as $S)
                                <div class="card">
                                    <h4>{{ $S->subject }}</h4>
                                    <button class="btn btn-outline-primary marksAddBtnSemOne"
                                        value="{{ $S->id }}">Add</button>
                                </div>
                            @endforeach
                        @else
                            <h1>No Data</h1>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div id="markInsertDiv" class="d-none">
                            @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                <input type="text" value="{{ $studentLists[0]->class }}" id="thisClass" hidden>
                                <input type="text" value="{{ $studentLists[0]->grade }}" id="thisGrade" hidden>
                            @endif
                            <div class="card">
                                @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                    @foreach ($studentLists as $st)
                                        <label for="input_{{ $st->id }}">{{ $st->studentFullName }}</label>
                                        <input type="text" class="form-control" id="input_{{ $st->id }}">
                                    @endforeach
                                    <button id="saveMarksSemOne" class="btn btn-primary" value="1">Save</button>
                                @else
                                    <h1>No students</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-top-semTwo" role="tabpanel">
                <div class="row container">
                    <div class="col-md-6">
                        @if ($subjects !== 'null' || $subjects->count() > 0)
                            @foreach ($subjects as $S)
                                <div class="card">
                                    <h4>{{ $S->subject }}</h4>
                                    <button class="btn btn-outline-primary marksAddBtnSemTwo"
                                        value="{{ $S->id }}">Add</button>
                                </div>
                            @endforeach
                        @else
                            <h1>No Data</h1>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div id="markInsertDivSemTwo" class="d-none">
                            @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                <input type="text" value="{{ $studentLists[0]->class }}" id="thisClass" hidden>
                                <input type="text" value="{{ $studentLists[0]->grade }}" id="thisGrade" hidden>
                            @endif
                            <div class="card">
                                @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                    @foreach ($studentLists as $st)
                                        <label for="input_{{ $st->id }}">{{ $st->studentFullName }}</label>
                                        <input type="text" class="form-control" id="input2_{{ $st->id }}">
                                    @endforeach
                                    <button id="saveMarksSemTwo" class="btn btn-primary" value="2">Save</button>
                                @else
                                    <h1>No students</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-top-semThee" role="tabpanel">
                <div class="row container">
                    <div class="col-md-6">
                        @if ($subjects !== 'null' || $subjects->count() > 0)
                            @foreach ($subjects as $S)
                                <div class="card">
                                    <h4>{{ $S->subject }}</h4>
                                    <button class="btn btn-outline-primary marksAddBtnSemThree"
                                        value="{{ $S->id }}">Add</button>
                                </div>
                            @endforeach
                        @else
                            <h1>No Data</h1>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div id="markInsertDivSemThree" class="d-none">
                            @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                <input type="text" value="{{ $studentLists[0]->class }}" id="thisClass" hidden>
                                <input type="text" value="{{ $studentLists[0]->grade }}" id="thisGrade" hidden>
                            @endif
                            <div class="card">
                                @if ($studentLists !== 'null' || $studentLists->count() > 0)
                                    @foreach ($studentLists as $st)
                                        <label for="input3_{{ $st->id }}">{{ $st->studentFullName }}</label>
                                        <input type="text" class="form-control" id="input3_{{ $st->id }}">
                                    @endforeach
                                    <button id="saveMarksSemThree" class="btn btn-primary" value="3">Save</button>
                                @else
                                    <h1>No students</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            //semester one
            $(document).on('click', '.marksAddBtnSemOne', function(e) {
                e.preventDefault();
                let subjectID = $(this).val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();
                $('#markInsertDiv').removeClass('d-none');
                $('#subid').val(subjectID);

                $('[id^=input_]').val('');

                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': 01,
                }

                $.ajax({
                    type: "get",
                    url: "/getSemOneMarksToEdit",
                    data: {
                        'data': data
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.stList) {
                            let studentMarks = res.stList;

                            studentMarks.forEach((student) => {
                                let studentId = student.studentID;
                                let marks = student.marks;

                                $(`#input_${studentId}`).val(marks);
                            });

                        } else {
                            console.log('no marks added!');
                        }
                    }
                });
            });

            // sem two
            $(document).on('click', '.marksAddBtnSemTwo', function(e) {
                e.preventDefault();
                let subjectID = $(this).val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();
                $('#markInsertDivSemTwo').removeClass('d-none');
                $('#subid').val(subjectID);

                $('[id^=input2_]').val('');

                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': 2,
                }

                $.ajax({
                    type: "get",
                    url: "/getSemOneMarksToEdit",
                    data: {
                        'data': data
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.stList) {
                            let studentMarks = res.stList;

                            studentMarks.forEach((student) => {
                                let studentId = student.studentID;
                                let marks = student.marks;

                                $(`#input2_${studentId}`).val(marks);
                            });

                        } else {
                            console.log('no marks added!');
                        }
                    }
                });
            });

            // sem three
            $(document).on('click', '.marksAddBtnSemThree', function(e) {
                e.preventDefault();
                let subjectID = $(this).val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();
                $('#markInsertDivSemThree').removeClass('d-none');
                $('#subid').val(subjectID);

                $('[id^=input3_]').val('');

                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': 3,
                }

                $.ajax({
                    type: "get",
                    url: "/getSemOneMarksToEdit",
                    data: {
                        'data': data
                    },
                    success: function(res) {
                        console.log(res);
                        if (res.stList) {
                            let studentMarks = res.stList;

                            studentMarks.forEach((student) => {
                                let studentId = student.studentID;
                                let marks = student.marks;

                                $(`#input3_${studentId}`).val(marks);
                            });

                        } else {
                            console.log('no marks added!');
                        }
                    }
                });
            });
        });

        $(document).ready(function() {

            // save and update sem one
            $(document).on('click', '#saveMarksSemOne', function(e) {
                e.preventDefault();

                $(this).prop('disabled', true);

                let inputValues = {};
                let subjectID = $('#subid').val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();


                $('[id^=input_]').each(function() {
                    let studentId = $(this).attr('id').replace('input_', '');
                    let inputValue = $(this).val();

                    if (inputValue === "") {
                        isValid = false;
                        // alert(`Input for student ${studentId} is empty.`);
                        $('#saveMarksSemOne').prop('disabled', false);
                        return false;
                    }

                    if (inputValue !== "ab") {
                        let numericValue = parseFloat(inputValue);
                        if (isNaN(numericValue) || numericValue < 0 || numericValue >
                            100) {
                            isValid = false;
                            alert(
                                `Invalid input for student ${studentId}. Please enter a number between 0 and 100.`
                            );
                            $('#saveMarks').prop('disabled', false);
                            return false;
                        }
                    }

                    inputValues[studentId] = inputValue;
                });

                console.log(inputValues);
                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': $(this).val(),
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "/savesemOneMarks",
                    data: {
                        'data': data,
                        'inputValues': inputValues,
                    },
                    success: function(res) {
                        // Re-enable the button after the AJAX request is complete
                        $('#saveMarks').prop('disabled', false);

                        if (res.success) {
                            $('[id^=input_]').val('');
                            $('#markInsertDiv').addClass('d-none');
                            console.log(res);
                        } else {
                            console.log(res);
                        }
                    },
                    error: function() {
                        // Re-enable the button in case of an error
                        $('#saveMarks').prop('disabled', false);
                    }
                });
            });

            // save and update sem two
            $(document).on('click', '#saveMarksSemTwo', function(e) {
                e.preventDefault();

                $(this).prop('disabled', true);

                let inputValues = {};
                let subjectID = $('#subid').val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();


                $('[id^=input2_]').each(function() {
                    let studentId = $(this).attr('id').replace('input2_', '');
                    let inputValue = $(this).val();

                    if (inputValue === "") {
                        isValid = false;
                        alert(`Input for student ${studentId} is empty.`);
                        $('#saveMarksSemTwo').prop('disabled', false);
                        return false;
                    }

                    if (inputValue !== "ab") {
                        let numericValue = parseFloat(inputValue);
                        if (isNaN(numericValue) || numericValue < 0 || numericValue >
                            100) {
                            isValid = false;
                            alert(
                                `Invalid input for student ${studentId}. Please enter a number between 0 and 100.`
                            );
                            $('#saveMarksSemTwo').prop('disabled', false);
                            return false;
                        }
                    }

                    inputValues[studentId] = inputValue;
                });

                console.log(inputValues);
                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': $(this).val(),
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "/savesemOneMarks",
                    data: {
                        'data': data,
                        'inputValues': inputValues,
                    },
                    success: function(res) {
                        // Re-enable the button after the AJAX request is complete
                        $('#saveMarksSemTwo').prop('disabled', false);

                        if (res.success) {
                            $('[id^=input2_]').val('');
                            $('#markInsertDivSemTwo').addClass('d-none');
                            // console.log(res);
                        } else {
                            // console.log(res);
                        }
                    }
                });
            });


             // save and update sem three
             $(document).on('click', '#saveMarksSemThree', function(e) {
                e.preventDefault();

                $(this).prop('disabled', true);

                let inputValues = {};
                let subjectID = $('#subid').val();
                let thisClass = $('#thisClass').val();
                let thisGrade = $('#thisGrade').val();
                let currentYear = new Date().getFullYear();


                $('[id^=input3_]').each(function() {
                    let studentId = $(this).attr('id').replace('input3_', '');
                    let inputValue = $(this).val();

                    if (inputValue === "") {
                        isValid = false;
                        alert(`Input for student ${studentId} is empty.`);
                        $('#saveMarksSemThree').prop('disabled', false);
                        return false;
                    }

                    if (inputValue !== "ab") {
                        let numericValue = parseFloat(inputValue);
                        if (isNaN(numericValue) || numericValue < 0 || numericValue >
                            100) {
                            isValid = false;
                            alert(
                                `Invalid input for student ${studentId}. Please enter a number between 0 and 100.`
                            );
                            $('#saveMarksSemThree').prop('disabled', false);
                            return false;
                        }
                    }

                    inputValues[studentId] = inputValue;
                });

                console.log(inputValues);
                let data = {
                    'subjectID': subjectID,
                    'thisClass': thisClass,
                    'thisGrade': thisGrade,
                    'currentYear': currentYear,
                    'semester': $(this).val(),
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "/savesemOneMarks",
                    data: {
                        'data': data,
                        'inputValues': inputValues,
                    },
                    success: function(res) {
                        $('#saveMarksSemThree').prop('disabled', false);

                        if (res.success) {
                            $('[id^=input3_]').val('');
                            $('#markInsertDivSemThree').addClass('d-none');
                            // console.log(res);
                        } else {
                            // console.log(res);
                        }
                    }
                });
            });

        });




        // $(document).ready(function() {
        //     $(document).on('click', '.marksEditBtnSemOne', function(e) {
        //         e.preventDefault();

        //         let subjectID2 = $('#subid').val();
        //         let thisClass2 = $('#thisClass').val();
        //         let thisGrade2 = $('#thisGrade').val();
        //         let currentYear2 = new Date().getFullYear();
        //         $('[id^=input_]').val('');

        //         let data2 = {
        //             'subjectID': subjectID2,
        //             'thisClass': thisClass2,
        //             'thisGrade': thisGrade2,
        //             'currentYear': currentYear2,
        //             'semester': 01,
        //         }

        //         console.log(data2);

        //         $.ajax({
        //             type: "get",
        //             url: "/getSemOneMarksToEdit",
        //             data: {
        //                 'data2': data2
        //             },
        //             success: function(res) {
        //                 console.log(res);
        //                 if (res.stList) {
        //                     let studentMarks = res.stList;

        //                     studentMarks.forEach((student) => {
        //                         let studentId = student.studentID;
        //                         let marks = student.marks;

        //                         $(`#input_${studentId}`).val(marks);
        //                     });

        //                 } else {
        //                     console.log('no marks added!');
        //                 }
        //             }
        //         });

        //     });
        // });
    </script>
@endsection
