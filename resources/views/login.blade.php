<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ url('assets/custom-css/login-custom-css.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>School Managment System</title>
</head>
<body>
    <div class="row">
        <div class="col-md-5">
            <div class="login-container">
                <div class="alert alert-danger" id="errorMessage" role="alert" style="display: none"></div>
    
                <h1 class="mb-4">Login</h1>
                <form>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="userName" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-eye-slash" id="togglePassword"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control" id="passWord" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-primary btn-block" id="LoginBtn">Login</button>
                    </div>
                    <div class="form-group">
                        <a href="#" class="text-muted">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div>
                <img src="{{ url('assets/images/backgrounds/login.png') }}" alt="" class="" style="width:800px;height700px">
            </div>
        </div>
    </div>
    
    
    


    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click','#LoginBtn',function (e) {
                e.preventDefault();

                let data = {
                    'userName':$('#userName').val(),
                    'passWord':$('#passWord').val(),
                }

                $.ajaxSetup({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "get",
                    url: "/checkUnAndPw",
                    data: data,
                    success: function (res) {
                        console.log(res);
                        if (res == 1) {
                            window.location = "/admin";
                        }else if (res == 2) {
                            window.location = "/teacher";
                        }else if (res.error) {
                            $('#errorMessage').text(res.error).show();
                            setTimeout(function () {
                                $('#errorMessage').fadeOut();
                            }, 5000);
                            console.log(res.error);
                        }
                    }
                });



            });
        });
    </script>
</body>
</html>