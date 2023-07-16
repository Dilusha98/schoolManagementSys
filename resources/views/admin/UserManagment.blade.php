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
            <h1 class="mt-2 mb-2">User Managment</h1>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-top-RegisterUsers" aria-controls="navs-top-RegisterUsers"
                        aria-selected="true">Register Users</button>
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
                                    <label for="" class="mt-2">Role</label>
                                    <select name="role" class="form-control" id="roleSelect">
                                        <option value="0">- Select -</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Teacher</option>
                                    </select>
                                    <label for="" class="mt-2">First Name</label>
                                    <input type="text" class="form-control" id="userFirstName">
                                    <label for="" class="mt-2">Last Name</label>
                                    <input type="text" class="form-control" id="userLastName">
                                    <label for="" class="mt-2">Email</label>
                                    <input type="email" class="form-control" id="userEmail">
                                    <label for="" class="mt-2">Address</label>
                                    <input type="text" class="form-control" id="userAddress">
                                    <label for="" class="mt-2">Telephone</label>
                                    <input type="tel" class="form-control" id="userTelephone">
                                    <label for="" class="mt-2">User Name</label>
                                    <input type="text" class="form-control" id="UserUserName">
                                    <label for="" class="mt-2">Date of birth</label>
                                    <input type="date" class="form-control mt-2" id="userDOB">
                                    <label for="" class="mt-2">Gender</label>
                                    <select name="gender" class="form-control" id="userGender">
                                        <option value="0">- Select -</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                    <label for="" class="mt-2">Password</label>
                                    <input type="password" class="form-control mt-2" id="userPassword">
                                    <label for="" class="mt-2">Confirm Password</label>
                                    <input type="password" class="form-control mt-2" id="userConfrmPW">
                                    <button class="btn btn-primary mt-3" id="UserSaveBtn">Save</button>
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
                                    <table class="table table-hover mb-10" id="UsersList">
                                        <thead style="text-align: center">
                                            <tr class="table-primary">
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0" style="text-align: center"
                                            id="UsersListTbody">
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
                    {{-- <div class="alert alert-success d-none" id="successalert" role="alert" style="z-index: 99999999"></div> --}}
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {

            // save User

            $(document).on('click', '#UserSaveBtn', function(e) {
                e.preventDefault();

                let role = $('#roleSelect').val();
                let userFirstName = $('#userFirstName').val();
                let userLastName = $('#userLastName').val();
                let userEmail = $('#userEmail').val();
                let userAddress = $('#userAddress').val();
                let userTelephone = $('#userTelephone').val();
                let UserUserName = $('#UserUserName').val();
                let userDOB = $('#userDOB').val();
                let userGender = $('#userGender').val();
                let userPassword = $('#userPassword').val();
                let userConfrmPW = $('#userConfrmPW').val();

                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (role == '' || userFirstName == '' || userLastName == '' || userAddress == '' ||
                    UserUserName == '' || userDOB == '' || userGender == '') {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Fill All fields !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                } else if (!emailPattern.test(userEmail)) {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Check Email Again !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                } else if (!$.isNumeric(userTelephone)) {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Check Telephone Again !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                } else if (userPassword.length < 8) {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Password should contain 8 charactors !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                } else if (userPassword != userConfrmPW) {
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text(
                        'Confirm Password dosent match !'
                    );
                    setTimeout(function() {
                        $('.alert-danger').addClass(
                            'd-none');
                    }, 5000);
                    window.scrollTo(0, 0);
                } else {

                    let data = {
                        'roleSelect': role,
                        'userFirstName': userFirstName,
                        'userLastName': userLastName,
                        'userEmail': userEmail,
                        'userAddress': userAddress,
                        'userTelephone': userTelephone,
                        'UserUserName': UserUserName,
                        'userDOB': userDOB,
                        'userGender': userGender,
                        'userPassword': userPassword,
                    }

                    // console.log(data);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "post",
                        url: "/saveUser",
                        data: data,
                        success: function(res) {
                            if (res.success) {
                                $('.alert-success').removeClass('d-none');
                                $('.alert-success').text(res.success);
                                setTimeout(function() {
                                    $('.alert-success').addClass('d-none');
                                }, 5000);

                                $('#roleSelect').val('');
                                $('#userFirstName').val('');
                                $('#userLastName').val('');
                                $('#userEmail').val('');
                                $('#userAddress').val('');
                                $('#userTelephone').val('');
                                $('#UserUserName').val('');
                                $('#userDOB').val('');
                                $('#userGender').val('');
                                $('#userPassword').val('');
                                $('#userConfrmPW').val('');
                                window.scrollTo(0, 0);
                                viewUserList();
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


            // view User
            viewUserList();

            function viewUserList() {
                $.ajax({
                    type: "get",
                    url: "/viewUserList",
                    success: function(res) {
                        $('#UsersList').DataTable().destroy();
                        $('#UsersListTbody').html("");
                        $.each(res.usersList, function(key, item) {
                            $('#UsersListTbody').append('<tr>\
                            <td>' + item.userFirstName + ' ' + item.userLastName + '</td>\
                            <td>' + item.userEmail + '</td>\
                            <td>' + item.role + '</td>\
                            <td><button class="btn btn-outline-info" id="EditUser" value="' + item.id + '">Edit</button>\
                                <button class="btn btn-outline-danger" id="DeleteUser" value="' + item.id + '">Delete</button>\
                                </td>\
                            </tr>');
                        });

                        $('#UsersList').DataTable({
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

            // delete user
            $(document).on('click', '#DeleteUser', function(e) {
                e.preventDefault();

                let id = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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

                        $.ajax({
                            type: "delete",
                            url: "/deleteUser/" + id,
                            success: function(res) {
                                if (res.success) {
                                    $('.alert-success').removeClass('d-none');
                                    $('.alert-success').text(res.success);
                                    setTimeout(function() {
                                        $('.alert-success').addClass('d-none');
                                    }, 5000);
                                    window.scrollTo(0, 0);
                                    viewUserList();
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
                })
            });

            // edit modal
            $(document).on('click', '#EditUser', function(e) {
                e.preventDefault();
                $('#EditUserModal').modal('show');

                let id = $(this).val();

                $.ajax({
                    type: "get",
                    url: "/viewUserListToEdit/" + id,
                    success: function(res) {
                        console.log(res);
                        $('#EditroleSelect').val(res.usersListtoEdit[0].role);
                        $('#EdituserFirstName').val(res.usersListtoEdit[0].userFirstName);
                        $('#EdituserLastName').val(res.usersListtoEdit[0].userLastName);
                        $('#EdituserEmail').val(res.usersListtoEdit[0].userEmail);
                        $('#EdituserAddress').val(res.usersListtoEdit[0].userAddress);
                        $('#EdituserTelephone').val(res.usersListtoEdit[0].userTelephone);
                        $('#EditUserUserName').val(res.usersListtoEdit[0].UserUserName);
                        $('#EdituserDOB').val(res.usersListtoEdit[0].userDOB);
                        $('#EdituserGender').val(res.usersListtoEdit[0].userGender);

                    }
                });

                // save changes
                $(document).on('click', '#SaveEditUser', function(e) {
                    e.preventDefault();

                    var editModal = $('#EditUserModal');

                    let Editedrole = $('#EditroleSelect').val();
                    let EditeduserFirstName = $('#EdituserFirstName').val();
                    let EditeduserLastName = $('#EdituserLastName').val();
                    let EditeduserEmail = $('#EdituserEmail').val();
                    let EditeduserAddress = $('#EdituserAddress').val();
                    let EditeduserTelephone = $('#EdituserTelephone').val();
                    let EditedUserUserName = $('#EditUserUserName').val();
                    let EditeduserDOB = $('#EdituserDOB').val();
                    let EditeduserGender = $('#EdituserGender').val();

                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (Editedrole == '' || EditeduserFirstName == '' || EditeduserLastName == '' ||
                        EditeduserAddress == '' || EditedUserUserName == '' || EditeduserDOB ==
                        '' || EditeduserGender == '') {
                        $('#dangeralert').removeClass('d-none');
                        $('#dangeralert').text(
                            'Fill All fields !'
                        );
                        setTimeout(function() {
                            $('.alert-danger').addClass(
                                'd-none');
                        }, 5000);
                        editModal.scrollTop(0);
                    } else if (!emailPattern.test(EditeduserEmail)) {
                        $('#dangeralert').removeClass('d-none');
                        $('#dangeralert').text(
                            'Check Email Again !'
                        );
                        setTimeout(function() {
                            $('#dangeralert').addClass(
                                'd-none');
                        }, 5000);
                        editModal.scrollTop(0);
                    } else if (!$.isNumeric(EditeduserTelephone)) {
                        $('#dangeralert').removeClass('d-none');
                        $('#dangeralert').text(
                            'Check Telephone Again !'
                        );
                        setTimeout(function() {
                            $('#dangeralert').addClass(
                                'd-none');
                        }, 5000);
                        editModal.scrollTop(0);
                    } else {

                        let data2 = {
                            'roleSelect': Editedrole,
                            'userFirstName': EditeduserFirstName,
                            'userLastName': EditeduserLastName,
                            'userEmail': EditeduserEmail,
                            'userAddress': EditeduserAddress,
                            'userTelephone': EditeduserTelephone,
                            'UserUserName': EditedUserUserName,
                            'userDOB': EditeduserDOB,
                            'userGender': EditeduserGender,
                        }

                        console.log('correct', data2);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "put",
                            url: "/updateUserDetails/" + id,
                            data: data2,
                            success: function(res) {
                                // console.log(res);
                                if (res.success) {
                                    $('#EditUserModal').modal('hide');
                                    $('.alert-success').removeClass('d-none');
                                    $('.alert-success').text(res.success);
                                    setTimeout(function() {
                                        $('.alert-success').addClass('d-none');
                                    }, 5000);
                                    window.scrollTo(0, 0);
                                    viewUserList();
                                    $('#EditroleSelect').val('');
                                    $('#EdituserFirstName').val('');
                                    $('#EdituserLastName').val('');
                                    $('#EdituserEmail').val('');
                                    $('#EdituserAddress').val('');
                                    $('#EdituserTelephone').val('');
                                    $('#EditUserUserName').val('');
                                    $('#EdituserDOB').val('');
                                    l$('#EdituserGender').val('');
                                } else {
                                    $('#dangeralert').removeClass('d-none');
                                    $('#dangeralert').text(
                                        'An error occurred while processing your request.'
                                    );
                                    setTimeout(function() {
                                        $('#dangeralert').addClass('d-none');
                                    }, 5000);
                                    editModal.scrollTop(0);
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
