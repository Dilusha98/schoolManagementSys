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
    User Managment
@endsection

@section('content')
    <div class="container">
        <div>
            <div class="alert alert-danger d-none" role="alert" style="z-index: 9999999"></div>
            <div class="alert alert-success d-none" role="alert" style="z-index: 99999999"></div>
        </div>
        <div class="card">
            <h1 class="mt-2 mb-2">Manage Classes</h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-RegisterUsers" aria-controls="navs-top-RegisterUsers"
                        aria-selected="true">Add Classes</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-Action" aria-controls="navs-top-Action"
                        aria-selected="false">Action</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-top-RegisterUsers" role="tabpanel">
                    <div class="row">
                        <div class="container mt-2">
                            <div id="RegisterUsersDiv">
                                <div>
                                    <label for="" class="mt-2">Select Grade: </label>
                                    <select name="grade" class="form-control" id="grade">
                                        <option value="0">- Select -</option>
                                        <option value="1">Grade 1</option>
                                        <option value="2">Grade 2</option>
                                        <option value="3">Grade 3</option>
                                        <option value="4">Grade 4</option>
                                        <option value="5">Grade 5</option>
                                        <option value="6">Grade 6</option>
                                        <option value="7">Grade 7</option>
                                        <option value="8">Grade 8</option>
                                        <option value="9">Grade 9</option>
                                        <option value="10">Grade 10</option>
                                        <option value="11">Grade 11</option>
                                        <option value="12">Grade 12</option>
                                        <option value="13">Grade 13</option>
                                    </select>

                                    <div id="streamDropdown" style="display: none;">
                                        <br>
                                        <label for="stream">Select Stream:</label>
                                        <select id="stream" class="form-control">
                                            <option value="0">Select</option>
                                            <option value="1">Science</option>
                                            <option value="2">Commerce</option>
                                            <option value="3">Arts</option>
                                            <option value="4">Technology </option>
                                        </select>
                                    </div>
                                    <br>
                                    <label for="" class="mt-2">Select Class: </label>
                                    <select name="class" class="form-control" id="class">
                                        <option value="0">- Select -</option>
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">C</option>
                                        <option value="4">D</option>
                                    </select>
                                    <br>
                                    <label for="" class="mt-2">Select Medium: </label>
                                    <select name="medium" class="form-control" id="medium">
                                        <option value="0">- Select -</option>
                                        <option value="1">Sinhala</option>
                                        <option value="2">English</option>
                                        <option value="3">Tamil</option>
                                    </select>
                                    <br>
                                    <button class="btn btn-primary mt-3" id="classSaveBtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-top-Action" role="tabpanel">
                    <div class="row">
                        <div class="container mt-2">
                            <div id="ActionTabDiv">
                                <div class="table-responsive text-nowrap container mt-3 mb-3">
                                    <table class="table table-hover mb-10" id="classList">
                                        <thead style="text-align: center">
                                            <tr class="table-primary">
                                                <th>Grade</th>
                                                <th>Class</th>
                                                <th>Medium</th>
                                                <th>Stream</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0" style="text-align: center" id="classListBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- edit user modal --}}
    <div class="modal fade" id="EditUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Edit User Details</h5>
                    <button type="button"class="btn-close"data-bs-dismiss="modal"aria-label="Close"></button>
                </div>
                <div class="container">
                    <div class="alert alert-danger d-none" id="dangeralert" role="alert" style="z-index: 9999999">
                    </div>
                    <div class="alert alert-success d-none" id="successalert" role="alert" style="z-index: 99999999">
                    </div>
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="" class="mt-2">Role</label>
                        <select name="role" class="form-control" id="EditroleSelect">
                            <option value="0">- Select -</option>
                            <option value="1">Admin</option>
                            <option value="2">Teacher</option>
                        </select>
                        <label for="" class="mt-2">First Name</label>
                        <input type="text" class="form-control" id="EdituserFirstName">
                        <label for="" class="mt-2">Last Name</label>
                        <input type="text" class="form-control" id="EdituserLastName">
                        <label for="" class="mt-2">Email</label>
                        <input type="email" class="form-control" id="EdituserEmail">
                        <label for="" class="mt-2">Address</label>
                        <input type="text" class="form-control" id="EdituserAddress">
                        <label for="" class="mt-2">Telephone</label>
                        <input type="tel" class="form-control" id="EdituserTelephone">
                        <label for="" class="mt-2">User Name</label>
                        <input type="text" class="form-control" id="EditUserUserName">
                        <label for="" class="mt-2">Date of birth</label>
                        <input type="date" class="form-control mt-2" id="EdituserDOB">
                        <label for="" class="mt-2">Gender</label>
                        <select name="gender" class="form-control" id="EdituserGender">
                            <option value="0">- Select -</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="modal-footer">
                    <button type="button" id="SaveEditUser" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#grade').change(function(e) {
                e.preventDefault();

                let A = $(this).val();
                console.log(A);
                if (A == "12" || A == "13") {
                    streamDropdown.style.display = "block";
                } else {
                    streamDropdown.style.display = "none";
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // save data
            $(document).on('click', '#classSaveBtn', function(e) {
                e.preventDefault();

                let stGrade = $('#grade').val();
                let stStream = $('#stream').val();
                let stClass = $('#class').val();
                let stMedium = $('#medium').val();

                if (stGrade == '0' || stClass == '0' || stMedium == '0') {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Fill All fields !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                }
                // else if {
                //     if (stGrade == '12' || stStream == '13') {
                //         if (stStream == '0') {
                //             $('.alert-danger').removeClass('d-none');
                //             $('.alert-danger').text(
                //                 'Fill All fields !'
                //             );
                //             setTimeout(function() {
                //                 $('.alert-danger').addClass(
                //                     'd-none');
                //             }, 5000);
                //             window.scrollTo(0, 0);
                //         }
                //     }
                // } 
                else {
                    let data = {
                        'grade': stGrade,
                        'stream': stStream,
                        'class': stClass,
                        'medium': stMedium
                    }
                    console.log(data);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "post",
                        url: "/saveClasses",
                        data: data,
                        success: function(res) {
                            if (res.success) {
                                $('.alert-success').removeClass('d-none');
                                $('.alert-success').text(res.success);
                                setTimeout(function() {
                                    $('.alert-success').addClass('d-none');
                                }, 5000);

                                $('#grade').val('0');
                                $('#stream').val('0');
                                $('#class').val('0');
                                $('#medium').val('0');
                                window.scrollTo(0, 0);
                                viewClass();
                            } else {
                                $('.alert-danger').removeClass('d-none');
                                $('.alert-danger').text(res.error);
                                setTimeout(function() {
                                    $('.alert-danger').addClass('d-none');
                                }, 5000);
                                window.scrollTo(0, 0);
                            }
                        }

                    });
                }

            });

            // view data
            viewClass();

            function viewClass() {
                $.ajax({
                    type: "get",
                    url: "/viewClassList",
                    success: function(res) {
                        console.log(res);
                        // $('#classList').DataTable().destroy();
                        $('#classListBody').html("");
                        $.each(res.classList, function(key, item) {
                            $('#classListBody').append('<tr>\
                            <td>' + item.grade + '</td>\
                            <td>' + item.class + '</td>\
                            <td>' + item.medium + '</td>\
                            <td>' + item.stream + '</td>\
                            <td><button class="btn btn-outline-info" id="editClass" value="' + item.id + '">Edit</button>\
                                <button class="btn btn-outline-danger" id="DeleteClass" value="' + item.id + '">Delete</button>\
                                </td>\
                            </tr>')
                        });
                    }
                });
            }

            // delete class

            $(document).on('click', '#DeleteClass', function(e) {
                e.preventDefault();

                let id = $(this).val();
                console.log(id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type : "delete",
                    url : "/deleteClass/"+id,
                    success: function(res){
                        if(res.success){
                            $('.alert-success').removeClass('d-none');
                        $('.alert-success').text(res.success);
                        setTimeout(function() {
                            $('.alert-success').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0,0);
                        viewClass();
                        } else{
                            $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').text(res.error);
                        setTimeout(function() {
                            $('.alert-danger').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0,0);
                        }
                    }

                });

            });




        });
    </script>
@endsection
