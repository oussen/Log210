<!-- resources/views/auth/register.blade.php -->
<head>
    <style rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"></style>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div>
        Name
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Phone
        <input type="text" name="phone" value="{{ old('phone') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation"> 
    </div>
	
	<div>
		<br>
		<input type="checkbox" name="isManager" value="1"> Manager
	</div>

    <div>
		<br>
        <button type="submit">Register</button>
    </div>
</form>