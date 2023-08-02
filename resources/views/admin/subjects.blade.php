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
    Subjects Managment
@endsection

@section('content')
<div class="container">
    <div>
        <div class="alert alert-danger d-none" role="alert" style="z-index: 9999999"></div>
        <div class="alert alert-success d-none" role="alert" style="z-index: 99999999"></div>
    </div>
    <div class="card">
        <h1 class="mt-2 mb-2">Subject Managment</h1>
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
                        <label for="">Subject Name</label>
                        <input type="text" id="subjectName" class="form-contrrol"><br>
                        <label for="">Description</label>
                        <textarea id="subjectDesc" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="container mt-2">
                        <label for="">grade 01</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="01"><br>
                        <label for="">grade 02</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="02"><br>
                        <label for="">grade 03</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="03"><br>
                        <label for="">grade 04</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="04"><br>
                        <label for="">grade 05</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="05"><br>
                        <label for="">grade 06</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="06"><br>
                        <label for="">grade 07</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="07"><br>
                        <label for="">grade 08</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="08"><br>
                        <label for="">grade 09</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="09"><br>
                        <label for="">grade 10</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="10"><br>
                        <label for="">grade 11</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="11"><br>
                        <label for="">grade 12</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="12"><br>
                        <label for="">grade 13</label>
                        <input type="checkbox" class="form-check-input subJectCheckBox" value="13"><br>
                    </div>
                </div>
                <div>
                    <button id="saveSubject" class="btn btn-primary">Save</button>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-top-Action" role="tabpanel">
                <div class="row">
                    <div class="container mt-2">
                        <div class="table-responsive text-nowrap mt-3 mb-3">
                            <table class="table table-hover mb-10">
                                <thead style="text-align: center">
                                    <tr class="table-primary">
                                        <th>Subject</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="subjectTbody" class="table-border-bottom-0" style="text-align: center">
                                </tbody>
                            </table>
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
    $(document).ready(function () {
        
        $(document).on('click','#saveSubject',function (e) {
            e.preventDefault();

            const checkboxes = document.getElementsByClassName('subJectCheckBox');
            const checkedValuesObject = {};
            let subject = $('#subjectName').val();
            let description = $('#subjectDesc').val();

            for (let i = 0; i < checkboxes.length; i++) {

                if (checkboxes[i].checked) {
                    const key = checkboxes[i].value;
                    const value = 1;
                    checkedValuesObject[key] = value;
                }else {
                    const key = checkboxes[i].value;
                    const value = 0;
                    checkedValuesObject[key] = value;
                }
            }
            checkedValuesObject['subject'] = subject;
            checkedValuesObject['description'] = description;
            console.log(checkedValuesObject);

            if (subject == '' || description == '') {
                console.log('fill all fields');
                $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').text('Fill all fields');
                    setTimeout(function() {
                    $('.alert-danger').addClass('d-none');
                }, 5000);

            } else {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: "/saveSubject",
                data: { checkedValuesObject: checkedValuesObject },
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').text(res.success);
                        setTimeout(function() {
                            $('.alert-success').addClass('d-none');
                        }, 5000);
                        window.scrollTo(0, 0);
                        $('#subjectName').val('');
                        $('#subjectDesc').val('');
                        $('input[type="checkbox"]').prop('checked', false);
                        viewSubjects();
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

        viewSubjects();
        function viewSubjects() {
            
            $.ajax({
                type: "get",
                url: "/viewSubjects",
                success: function (res) {
                    console.log(res);
                    if (res.length == '0') {
                        $('#subjectTbody').append('<tr>\
                            <td colspan="3">No Data</td>\
                        </tr>');
                    } else {
                        $('#subjectTbody').html('');
                        $.each(res, function (key, item) { 
                            $('#subjectTbody').append('<tr>\
                                <td>'+item.subject+'</td>\
                                <td>'+item.description+'</td>\
                                <td><button id="DeleteSubject" class="btn btn-outline-danger" value="'+item.id+'">Delete</button></td>\
                            </tr>');
                        });
                    }
                }
            });
        }

        $(document).on('click','#DeleteSubject',function (e) {
            e.preventDefault();
            let id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "delete",
                url: "/deleteSubject/"+id,
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('.alert-success').removeClass('d-none');
                        $('.alert-success').text(res.success);
                        setTimeout(function() {
                            $('.alert-success').addClass('d-none');
                        }, 5000);
                        viewSubjects();
                        window.scrollTo(0, 0);
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
        });

    });
</script>
    
@endsection