<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>login</h1>
    <input type="text" class="form-control" id="userName" placeholder="username">
    <input type="password" class="form-control" id="passWord" placeholder="password">
    <button class="btn btn-primary" id="LoginBtn">Login</button>


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
                            console.log(res.error);
                        }
                    }
                });



            });
        });
    </script>
</body>
</html>