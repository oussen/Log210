<!-- resources/views/auth/login.blade.php -->
<head>
    <!--
        SCRIPTS
    -->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("button").click(function(){
                //if = -1, the login is not an email, otherwise it is
                if($('input[name=login]').val().indexOf("@") == -1){
                    $("#hiddenPhone").val($('input[name=login]').val())
                    console.log($("#hiddenPhone").val())
                } else {
                    $("#hiddenEmail").val($('input[name=login]').val())
                    console.log($("#hiddenEmail").val())
                }
            })
        });
    </script>
</head>

<body>
<div class="container col-md-3 col-md-offset-4">
    <form method="POST" action="/auth/login">
        {!! csrf_field() !!}

        <div>
            Email/Phone Number
            <input class="form-control" type="text" name="login" value="{{ old('email') }}">
        </div>

        <div>
            Password
            <input class="form-control" type="password" name="password" id="password">
        </div>

        <div>
            <input type="checkbox" name="remember"> Remember Me
        </div>

        <div>
            <button class="form-control" type="submit">Login</button>
            <input type="hidden" id="hiddenEmail" name="email" value="" />
            <input type="hidden" id="hiddenPhone" name="phone" value="" />
        </div>
    </form>
</div>
</body>