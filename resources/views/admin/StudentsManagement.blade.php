@php
    use Illuminate\Support\Facades\DB;
@endphp
@php
    $name = session()->get('name');
    // $data = DB::table('userregistation')->get();
    $data = session()->get('user');
    $dataarray = json_decode($data, true);
@endphp
@if ($name != 'admin')
    @php
        header('Location: ' . URL::to('/'), true, 302);
        exit();
    @endphp
@endif

@extends('layout')

@section('title')
    Students Managment
@endsection

@section('content')
    <div class="container">
        <div>
            <div class="alert alert-danger d-none" role="alert" style="z-index: 9999999"></div>
            <div class="alert alert-success d-none" role="alert" style="z-index: 99999999"></div>
        </div>
        <div class="card">
            <h1 class="mt-2 mb-2">Student Management</h1>
        </div>
    </div>
    <div class="container">
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-RegisterStudents" aria-controls="navs-top-RegisterStudents"
                    aria-selected="true">Register Users</button>
            </li>
            <li class="nav-item">
                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                    data-bs-target="#navs-top-ActionStudents" aria-controls="navs-top-ActionStudents"
                    aria-selected="false">Action</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-top-RegisterStudents" role="tabpanel">
                <div>
                    <div class="card container">
                        <span>Student's Details</span>
                        <div class="mt-3">
                            <label for="">Full Name</label>
                            <input type="text" class="form-control mb-2 mt-1" id="StudentFullName">
                            <label for="">Initials</label>
                            <input type="text" class="form-control mb-2 mt-1" id="studentInitials">
                            <label for="">Date of Birth</label>
                            <input type="date" class="form-control mb-2 mt-1" id="studentDOB">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control mb-2 mt-1" id="studentGender">
                                <option value="0">- Select -</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <label for="">Nationality</label>
                            <select name="nationality" class="form-control mb-2 mt-1" id="studentNationality">
                                <option value="0">- Select -</option>
                                <option value="Sinhala">Sinhala</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Muslim">Muslim</option>
                            </select>
                        </div>
                    </div>
                    <div class="card container">
                        <span>Guardian's Details</span>
                        <div class="mt-3">
                            <div class="mb-2">
                                <label>
                                    <input type="radio" name="parent" value="mom" id="mom"> Mother &nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="radio" name="parent" value="dad" id="dad"> Father &nbsp;&nbsp;
                                </label>
                                <label>
                                    <input type="radio" name="parent" value="guardian" id="guardiann"> Guardian
                                    &nbsp;&nbsp;
                                </label>
                            </div>
                            <label for="">Full Name</label>
                            <input type="text" class="form-control mb-2 mt-1" id="guardianFullName">
                            <label for="">Initials</label>
                            <input type="text" class="form-control mb-2 mt-1" id="guardianInitials">
                            <label for="">National ID Number</label>
                            <input type="text" class="form-control mb-2 mt-1" id="guardianNIC">
                            <label for="">Date of Birth</label>
                            <input type="date" class="form-control mb-2 mt-1" id="guardianDob">
                            <label for="">Email </label>
                            <input type="email" class="form-control mb-2 mt-1" id="guardianEmail">
                            <label for="">permanent Address</label>
                            <input type="text" class="form-control mb-2 mt-1" id="guardinaAddress">
                            <label for="">Postal Code</label>
                            {{-- <input type="number" class="form-control mb-2 mt-1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" id="guardianPostalCode"> --}}
                            <input type="text" class="form-control mb-2 mt-1" id="guardianPostalCode" pattern="\d*"
                                maxlength="5"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                            <label for="">Occupation</label>
                            <input type="text" class="form-control mb-2 mt-1" id="guardianOccupation">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" id="registerStudentBtn">Register</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-top-ActionStudents" role="tabpanel">
                <div class="container">
                    <div id="ActionTabDiv2">
                        <div class="table-responsive text-nowrap container mt-3 mb-3">
                            <table class="table table-hover mb-10" id="studentsList">
                                <thead style="text-align: center">
                                    <tr class="table-primary">
                                        <th>Student Name</th>
                                        <th>Guardian Name</th>
                                        <th>Guardian NIC</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0" style="text-align: center" id="studentsListTbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- edit student Modal --}}

    <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Edit Student Details</h5>
                    <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                </div>
                <div class="container">
                    <div class="alert alert-danger d-none" id="dangeralert" role="alert" style="z-index: 9999999">
                    </div>
                    {{-- <div class="alert alert-success d-none" id="successalert" role="alert" style="z-index: 99999999"></div> --}}
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="card container">
                            <span>Student's Details</span>
                            <div class="mt-3">
                                <label for="">Full Name</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditStudentFullName">
                                <label for="">Initials</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditstudentInitials">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control mb-2 mt-1" id="EditstudentDOB">
                                <label for="">Gender</label>
                                <select name="gender" class="form-control mb-2 mt-1" id="EditstudentGender">
                                    <option value="0">- Select -</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <label for="">Nationality</label>
                                <select name="nationality" class="form-control mb-2 mt-1" id="EditstudentNationality">
                                    <option value="0">- Select -</option>
                                    <option value="Sinhala">Sinhala</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                </select>
                            </div>
                        </div>
                        <div class="card container">
                            <span>Guardian's Details</span>
                            <div class="mt-3">
                                <div class="mb-2">
                                    <label>
                                        <input type="radio" name="parent" value="mom" id="Editmom"> Mother
                                        &nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input type="radio" name="parent" value="dad" id="Editdad"> Father
                                        &nbsp;&nbsp;
                                    </label>
                                    <label>
                                        <input type="radio" name="parent" value="guardian" id="Editguardiann">
                                        Guardian
                                        &nbsp;&nbsp;
                                    </label>
                                </div>
                                <label for="">Full Name</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardianFullName">
                                <label for="">Initials</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardianInitials">
                                <label for="">National ID Number</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardianNIC">
                                <label for="">Date of Birth</label>
                                <input type="date" class="form-control mb-2 mt-1" id="EditguardianDob">
                                <label for="">Email</label>
                                <input type="email" class="form-control mb-2 mt-1" id="EditguardianEmail">
                                <label for="">permanent Address</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardinaAddress">
                                <label for="">Postal Code</label>
                                {{-- <input type="number" class="form-control mb-2 mt-1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="5" id="guardianPostalCode"> --}}
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardianPostalCode"
                                    pattern="\d*" maxlength="5"
                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <label for="">Occupation</label>
                                <input type="text" class="form-control mb-2 mt-1" id="EditguardianOccupation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" id="SaveEditStudent" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            setStudentInitials();

            function setStudentInitials() {
                $('#StudentFullName').change(function(e) {
                    e.preventDefault();

                    let stFullName = $('#StudentFullName').val();

                    let words = stFullName.split(" ");
                    let initials = "";

                    for (var i = 0; i < words.length; i++) {
                        initials += words[i].charAt(0).toUpperCase() + '.';
                    }
                    $('#studentInitials').val(initials);
                });
            }

            EditSetStudentInitials();

            function EditSetStudentInitials() {
                $('#EditStudentFullName').change(function(e) {
                    e.preventDefault();

                    let stFullName = $('#EditStudentFullName').val();

                    let words = stFullName.split(" ");
                    let initials = "";

                    for (var i = 0; i < words.length; i++) {
                        initials += words[i].charAt(0).toUpperCase() + '.';
                    }
                    $('#EditstudentInitials').val(initials);
                });
            }

            setGuardianInitials();

            function setGuardianInitials() {
                $('#guardianFullName').change(function(e) {
                    e.preventDefault();

                    let guarFullName = $('#guardianFullName').val();

                    let Gwords = guarFullName.split(" ");
                    let Ginitials = "";

                    for (var i = 0; i < Gwords.length; i++) {
                        Ginitials += Gwords[i].charAt(0).toUpperCase() + '.';
                    }
                    $('#guardianInitials').val(Ginitials);
                });
            }

            EditsetGuardianInitials();

            function EditsetGuardianInitials() {
                $('#EditguardianFullName').change(function(e) {
                    e.preventDefault();

                    let guarFullName = $('#EditguardianFullName').val();

                    let Gwords = guarFullName.split(" ");
                    let Ginitials = "";

                    for (var i = 0; i < Gwords.length; i++) {
                        Ginitials += Gwords[i].charAt(0).toUpperCase() + '.';
                    }
                    $('#EditguardianInitials').val(Ginitials);
                });
            }

            setGuardianDOB();

            function setGuardianDOB() {
                $('#guardianNIC').change(function(e) {
                    e.preventDefault();
                    //guardianDob
                    let NICNo = $('#guardianNIC').val();

                    if (NICNo.length != 10 && NICNo.length != 12) {
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').text(res.error);
                        setTimeout(function() {
                            $('.alert-danger').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                    } else if (NICNo.length == 10 && !$.isNumeric(NICNo.substr(0, 9))) {
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').text(res.error);
                        setTimeout(function() {
                            $('.alert-danger').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                    } else {
                        // Year
                        if (NICNo.length == 10) {
                            year = "19" + NICNo.substr(0, 2);
                            dayText = parseInt(NICNo.substr(2, 3));
                        } else {
                            year = NICNo.substr(0, 4);
                            dayText = parseInt(NICNo.substr(4, 3));
                        }

                        // Gender
                        if (dayText > 500) {
                            gender = "Female";
                            dayText = dayText - 500;
                        } else {
                            gender = "Male";
                        }

                        // Day Digit Validation
                        if (dayText < 1 && dayText > 366) {
                            $("#error").html("Invalid NIC NO");
                        } else {

                            //Month
                            if (dayText > 335) {
                                day = dayText - 335;
                                month = 12;
                            } else if (dayText > 305) {
                                day = dayText - 305;
                                month = 11;
                            } else if (dayText > 274) {
                                day = dayText - 274;
                                month = 10;
                            } else if (dayText > 244) {
                                day = dayText - 244;
                                month = 09;
                            } else if (dayText > 213) {
                                day = dayText - 213;
                                month = 08;
                            } else if (dayText > 182) {
                                day = dayText - 182;
                                month = 07;
                            } else if (dayText > 152) {
                                day = dayText - 152;
                                month = 06;
                            } else if (dayText > 121) {
                                day = dayText - 121;
                                month = 05;
                            } else if (dayText > 91) {
                                day = dayText - 91;
                                month = 04;
                            } else if (dayText > 60) {
                                day = dayText - 60;
                                month = 03;
                            } else if (dayText < 32) {
                                month = 01;
                                day = dayText;
                            } else if (dayText > 31) {
                                day = dayText - 31;
                                month = 02;
                            }

                            var Months = month.toString().padStart(2, '0');
                            var date = day.toString().padStart(2, '0');
                            var birthday = year + '-' + Months + '-' + date;
                            // Show Details
                            var guardianDobInput = document.getElementById("guardianDob");
                            var birthdayDate = new Date(birthday);
                            var formattedBirthday = birthdayDate.toISOString().split('T')[0];
                            guardianDobInput.value = formattedBirthday;
                        }
                    }

                });
            }


            EditsetGuardianDOB();

            function EditsetGuardianDOB() {
                $('#EditguardianNIC').change(function(e) {
                    e.preventDefault();
                    //guardianDob
                    let NICNo = $('#EditguardianNIC').val();

                    if (NICNo.length != 10 && NICNo.length != 12) {
                        $('#dangeralert').removeClass('d-none');
                        $('#dangeralert').text(res.error);
                        setTimeout(function() {
                            $('#dangeralert').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                    } else if (NICNo.length == 10 && !$.isNumeric(NICNo.substr(0, 9))) {
                        $('#dangeralert').removeClass('d-none');
                        $('#dangeralert').text(res.error);
                        setTimeout(function() {
                            $('#dangeralert').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                    } else {
                        // Year
                        if (NICNo.length == 10) {
                            year = "19" + NICNo.substr(0, 2);
                            dayText = parseInt(NICNo.substr(2, 3));
                        } else {
                            year = NICNo.substr(0, 4);
                            dayText = parseInt(NICNo.substr(4, 3));
                        }

                        // Gender
                        if (dayText > 500) {
                            gender = "Female";
                            dayText = dayText - 500;
                        } else {
                            gender = "Male";
                        }

                        // Day Digit Validation
                        if (dayText < 1 && dayText > 366) {
                            $("#error").html("Invalid NIC NO");
                        } else {

                            //Month
                            if (dayText > 335) {
                                day = dayText - 335;
                                month = 12;
                            } else if (dayText > 305) {
                                day = dayText - 305;
                                month = 11;
                            } else if (dayText > 274) {
                                day = dayText - 274;
                                month = 10;
                            } else if (dayText > 244) {
                                day = dayText - 244;
                                month = 09;
                            } else if (dayText > 213) {
                                day = dayText - 213;
                                month = 08;
                            } else if (dayText > 182) {
                                day = dayText - 182;
                                month = 07;
                            } else if (dayText > 152) {
                                day = dayText - 152;
                                month = 06;
                            } else if (dayText > 121) {
                                day = dayText - 121;
                                month = 05;
                            } else if (dayText > 91) {
                                day = dayText - 91;
                                month = 04;
                            } else if (dayText > 60) {
                                day = dayText - 60;
                                month = 03;
                            } else if (dayText < 32) {
                                month = 01;
                                day = dayText;
                            } else if (dayText > 31) {
                                day = dayText - 31;
                                month = 02;
                            }

                            var Months = month.toString().padStart(2, '0');
                            var date = day.toString().padStart(2, '0');
                            var birthday = year + '-' + Months + '-' + date;
                            // Show Details
                            var guardianDobInput = document.getElementById("EditguardianDob");
                            var birthdayDate = new Date(birthday);
                            var formattedBirthday = birthdayDate.toISOString().split('T')[0];
                            guardianDobInput.value = formattedBirthday;
                        }
                    }

                });
            }

            // Register Student
            $(document).on('click', '#registerStudentBtn', function(e) {
                e.preventDefault();

                var momRadioButton = document.getElementById("mom");
                var dadRadioButton = document.getElementById("dad");
                var guardianRadioButton = document.getElementById("guardiann");

                if (momRadioButton.checked) {
                    var guardianType = momRadioButton.value
                } else if (dadRadioButton.checked) {
                    var guardianType = dadRadioButton.value
                } else if (guardianRadioButton.checked) {
                    var guardianType = guardianRadioButton.value
                }

                let data = {
                    'studentFullName': $('#StudentFullName').val(),
                    'studentInitials': $('#studentInitials').val(),
                    'studentBirthday': $('#studentDOB').val(),
                    'studentGender': $('#studentGender').val(),
                    'studentNationality': $('#studentNationality').val(),
                    'guardianType': guardianType,
                    'guardianFullName': $('#guardianFullName').val(),
                    'guardianInitials': $('#guardianInitials').val(),
                    'guardianNIC': $('#guardianNIC').val(),
                    'guardianBirthday': $('#guardianDob').val(),
                    'guardianEmail': $('#guardianEmail').val(),
                    'guardianAddress': $('#guardinaAddress').val(),
                    'guardianPostalCode': $('#guardianPostalCode').val(),
                    'guardianOccupation': $('#guardianOccupation').val(),
                }

                console.log(data);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "/registerStudents",
                    data: data,
                    success: function(res) {
                        console.log(res);
                        if (res.success) {
                            $('.alert-success').removeClass('d-none');
                            $('.alert-success').text(res.success);
                            setTimeout(function() {
                                $('.alert-success').addClass('d-none');
                            }, 5000);
                            window.scrollTo(0, 0);
                            viewStudentsList();
                            $('#StudentFullName').val('');
                            $('#studentInitials').val('');
                            $('#studentDOB').val('');
                            $('#studentGender').val('0');
                            $('#studentNationality').val('');
                            $('#guardianFullName').val('');
                            $('#guardianInitials').val('');
                            $('#guardianNIC').val('');
                            $('#guardianDob').val('');
                            $('#guardinaAddress').val('');
                            $('#guardianPostalCode').val('');
                            $('#guardianOccupation').val('');
                            $('#guardianEmail').val('');

                            if (momRadioButton.checked) {
                                momRadioButton.checked = false;
                            } else if (dadRadioButton.checked) {
                                dadRadioButton.checked = false;
                            } else if (guardianRadioButton.checked) {
                                guardianRadioButton.checked = false;
                            }
                        } else {
                            $('.alert-danger').removeClass('d-none');
                            $('.alert-danger').text(res.error);
                            setTimeout(function() {
                                $('.alert-danger').addClass('d-none');
                            }, 5000);
                            window.scrollTo(0, 0);
                            viewStudentsList();
                        }
                    },
                    error: function(xhr, status, error) {

                        var errors = xhr.responseJSON.errors;
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').text(errors.studentFullName);
                        $('.alert-danger').text(errors.studentInitials);
                        $('.alert-danger').text(errors.studentBirthday);
                        $('.alert-danger').text(errors.studentGender);
                        $('.alert-danger').text(errors.studentNationality);
                        $('.alert-danger').text(errors.guardianType);
                        $('.alert-danger').text(errors.guardianFullName);
                        $('.alert-danger').text(errors.guardianInitials);
                        $('.alert-danger').text(errors.guardianNIC);
                        $('.alert-danger').text(errors.guardianBirthday);
                        $('.alert-danger').text(errors.guardianAddress);
                        $('.alert-danger').text(errors.guardianPostalCode);
                        $('.alert-danger').text(errors.guardianOccupation);
                        $('.alert-danger').text(errors.guardianEmail);
                        setTimeout(function() {
                            $('.alert-danger').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                    }
                });
            });

            viewStudentsList();

            function viewStudentsList() {

                $.ajax({
                    type: "get",
                    url: "/viewStudentsList",
                    success: function(res) {
                        // console.log(res.studentsList);

                        $('#studentsList').DataTable().destroy();
                        $('#studentsListTbody').html("");
                        $.each(res.studentsList, function(key, item) {
                            $('#studentsListTbody').append('<tr>\
                                <td>' + item.studentFullName + '</td>\
                                <td>' + item.guardianFullName + '</td>\
                                <td>' + item.guardianNIC +
                                '</td>\
                                <td><button class="btn btn-outline-info" id="EditStudent" value="' +item.id +'">Edit</button>\
                                <button class="btn btn-outline-danger" id="DeleteStudent" value="' +item.id + '">Delete</button>\
                                </td>\
                                </tr>');
                        });

                        $('#studentsList').DataTable({
                            paging: true, // Enable pagination
                            pageLength: 10, // Number of records per page
                            lengthMenu: [10, 20, 30, 40], // Page length options
                            //lengthChange: false,
                            //searching: false, 
                            language: {
                                // Custom text for pagination controls
                                paginate: {
                                    first: 'First',
                                    last: 'Last',
                                    next: '<i class="bx bx-chevron-right"></i>',
                                    previous: '<i class="bx bx-chevron-left"></i>'
                                }
                            }
                        });
                    }
                });
            }

            $(document).on('click', '#DeleteStudent', function(e) {
                e.preventDefault();
                let id = $(this).val();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "delete",
                            url: "/deleteStudents/" + id,
                            success: function(res) {
                                console.log(res);
                                if (res.success) {
                                    $('.alert-success').removeClass('d-none');
                                    $('.alert-success').text(res.success);
                                    setTimeout(function() {
                                        $('.alert-success').addClass('d-none');
                                    }, 5000);
                                    window.scrollTo(0, 0);
                                    viewStudentsList();
                                } else {
                                    $('.alert-danger').removeClass('d-none');
                                    $('.alert-danger').text(res.error);
                                    setTimeout(function() {
                                        $('.alert-danger').addClass('d-none');
                                    }, 5000);
                                    window.scrollTo(0, 0);
                                    viewStudentsList();
                                }
                            }
                        });
                    }
                })
            });

            $(document).on('click', '#EditStudent', function(e) {
                e.preventDefault();
                $('#EditStudentModal').modal('show');
                let id = $(this).val();

                $.ajax({
                    type: "get",
                    url: "/getToEditStudent/" + id,
                    success: function(res) {
                        console.log(res);

                        $('#EditStudentFullName').val(res.student[0].studentFullName);
                        $('#EditstudentInitials').val(res.student[0].studentInitials);
                        $('#EditstudentDOB').val(res.student[0].studentBirthday);
                        $('#EditstudentGender').val(res.student[0].studentGender);
                        $('#EditstudentNationality').val(res.student[0].studentNationality);
                        $('#EditguardianFullName').val(res.student[0].guardianFullName);
                        $('#EditguardianInitials').val(res.student[0].guardianInitials);
                        $('#EditguardianNIC').val(res.student[0].guardianNIC);
                        $('#EditguardianDob').val(res.student[0].guardianBirthday);
                        $('#EditguardinaAddress').val(res.student[0].guardianAddress);
                        $('#EditguardianPostalCode').val(res.student[0].guardianPostalCode);
                        $('#EditguardianOccupation').val(res.student[0].guardianOccupation);
                        $('#EditguardianEmail').val(res.student[0].guardianEmail);

                        var momRadioButton = document.getElementById("Editmom");
                        var dadRadioButton = document.getElementById("Editdad");
                        var guardianRadioButton = document.getElementById("Editguardiann");

                        if (res.student[0].guardianType == 'mom') {
                            momRadioButton.checked = true;
                        } else if (res.student[0].guardianType == 'dad') {
                            dadRadioButton.checked = true;;
                        } else if (res.student[0].guardianType == 'guadian') {
                            guardianRadioButton.checked = true;;
                        }
                    }
                });

                $(document).on('click', '#SaveEditStudent', function(e) {
                    e.preventDefault();

                    var momRadioButton = document.getElementById("Editmom");
                    var dadRadioButton = document.getElementById("Editdad");
                    var guardianRadioButton = document.getElementById("Editguardiann");
                    var editModal = $('#EditStudentModal');

                    if (momRadioButton.checked) {
                        var guardianType = momRadioButton.value
                    } else if (dadRadioButton.checked) {
                        var guardianType = dadRadioButton.value
                    } else if (guardianRadioButton.checked) {
                        var guardianType = guardianRadioButton.value
                    }

                    let data = {
                        'studentFullName': $('#EditStudentFullName').val(),
                        'studentInitials': $('#EditstudentInitials').val(),
                        'studentBirthday': $('#EditstudentDOB').val(),
                        'studentGender': $('#EditstudentGender').val(),
                        'studentNationality': $('#EditstudentNationality').val(),
                        'guardianType': guardianType,
                        'guardianFullName': $('#EditguardianFullName').val(),
                        'guardianInitials': $('#EditguardianInitials').val(),
                        'guardianNIC': $('#EditguardianNIC').val(),
                        'guardianBirthday': $('#EditguardianDob').val(),
                        'guardianEmail': $('#EditguardianEmail').val(),
                        'guardianAddress': $('#EditguardinaAddress').val(),
                        'guardianPostalCode': $('#EditguardianPostalCode').val(),
                        'guardianOccupation': $('#EditguardianOccupation').val(),
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "put",
                        url: "/SaveEditedstudentDetails/" + id,
                        data: data,
                        success: function(res) {
                            console.log(res);
                            if (res.success) {
                                $('.alert-success').removeClass('d-none');
                                $('.alert-success').text(res.success);
                                setTimeout(function() {
                                    $('.alert-success').addClass('d-none');
                                }, 5000);
                                window.scrollTo(0, 0);
                                viewStudentsList();
                                $('#EditStudentModal').modal('hide');
                                $('#EditStudentFullName').val('');
                                $('#EditstudentInitials').val('');
                                $('#EditstudentDOB').val('');
                                $('#EditstudentGender').val('0');
                                $('#EditstudentNationality').val('');
                                $('#EditguardianFullName').val('');
                                $('#EditguardianInitials').val('');
                                $('#EditguardianNIC').val('');
                                $('#EditguardianDob').val('');
                                $('#EditguardinaAddress').val('');
                                $('#EditguardianPostalCode').val('');
                                $('#EditguardianOccupation').val('');
                                $('#EditguardianEmail').val('');

                                if (momRadioButton.checked) {
                                    momRadioButton.checked = false;
                                } else if (dadRadioButton.checked) {
                                    dadRadioButton.checked = false;
                                } else if (guardianRadioButton.checked) {
                                    guardianRadioButton.checked = false;
                                }
                            } else {
                                $('#dangeralert').removeClass('d-none');
                                $('#dangeralert').text(res.error);
                                setTimeout(function() {
                                    $('#dangeralert').addClass('d-none');
                                }, 5000);
                                editModal.scrollTop(0);
                            }
                        },
                        error: function(xhr, status, error) {

                            var errors = xhr.responseJSON.errors;
                            $('#dangeralert').removeClass('d-none');
                            $('#dangeralert').text(errors.studentFullName);
                            $('#dangeralert').text(errors.studentInitials);
                            $('#dangeralert').text(errors.studentBirthday);
                            $('#dangeralert').text(errors.studentGender);
                            $('#dangeralert').text(errors.studentNationality);
                            $('#dangeralert').text(errors.guardianType);
                            $('#dangeralert').text(errors.guardianFullName);
                            $('#dangeralert').text(errors.guardianInitials);
                            $('#dangeralert').text(errors.guardianNIC);
                            $('#dangeralert').text(errors.guardianBirthday);
                            $('#dangeralert').text(errors.guardianAddress);
                            $('#dangeralert').text(errors.guardianPostalCode);
                            $('#dangeralert').text(errors.guardianOccupation);
                            $('#dangeralert').text(errors.guardianEmail);
                            setTimeout(function() {
                                $('#dangeralert').addClass('d-none');
                            }, 5000);
                            editModal.scrollTop(0);
                        }
                    });
                });
            });

        });
    </script>
@endsection
