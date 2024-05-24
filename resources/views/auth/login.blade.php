<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width">
    <title>Login Page</title>
    <style>
        .container {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin:0 auto;
            max-width: 400px;
        }
        .login-container h2 {
            margin: 0 0 20px;
            text-align: center;
        }
        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .login-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .invalid-feedback{
            color: red;
        }
        .logo-image-container{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-image-container > img{
            width: 60%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-container">
        <div class="logo-image-container">
        <img src="{{ asset('image/login-logo.jpeg') }}" alt="logo">
        </div>
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <label for="email">EMAIL</label>
            <input type="text" id="email" name="email">
            <label for="password">PASSWORD</label>
            <input type="password" id="password" name="password">
            @error('email')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <input type="submit" value="SUBMIT">
            <a href="forgot_password" id="forgot_password">Forgot Password</a>
        </form>
    </div>
</div>
<script type="text/javascript">
        function showAlert(event) {
            event.preventDefault(); // Prevents the default action of the link
            alert("send to this email to reset your password:admin@admin.com");
        }

        // Add the event listener to the link when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            var link = document.getElementById('forgot_password');
            link.addEventListener('click', showAlert);
        });
    </script>
</body>
</html>

