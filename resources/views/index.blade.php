<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>
    <div class="login-page">
        <div class="form">
            <h2>Login Form</h2>
            <form method="post" action="{{ route('user.login') }}">
                @csrf
                <input type="text" placeholder="Enter Email" name="email" class="@error('email') is-invalid @enderror"/>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="password" placeholder="Enter Password" name="password" class="@error('password') is-invalid @enderror"/>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <button>login</button>
                <p class="message">Not registered? <a href="{{route('register')}}">Create an account</a></p>
            </form>
        </div>
      </div>
</body>
</html>