<!-- resources/views/auth/register.blade.php -->

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