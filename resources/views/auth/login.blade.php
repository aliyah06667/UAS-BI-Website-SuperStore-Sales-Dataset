<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SerbaSerbi.</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=EB+Garamond:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-plum: #5D3340;
            --plum-mid: #7A4055;
            --accent-pink: #FF5CA8;
            --soft-pink: #F9DCE7;
            --bg-base: #FFF9FB;
            --text-dark: #3A2030;
            --text-muted: #A08090;
            --shadow-card: 0 20px 60px rgba(93, 51, 64, .15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #FFF9FB 0%, #F9DCE7 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Card Container murni terpusat */
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 50px 40px;
            box-shadow: var(--shadow-card), 0 0 40px rgba(255, 92, 168, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .login-title {
            font-family: 'EB Garamond', serif;
            font-size: 42px;
            color: var(--primary-plum);
            text-align: center;
            margin-bottom: 6px;
            font-weight: 800;
            line-height: 1.1;
        }

        .login-sub {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 35px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: var(--primary-plum);
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control-custom {
            width: 100%;
            border-radius: 16px;
            border: 1px solid #f3dce5;
            padding: 14px 18px;
            background: white;
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            outline: none;
            transition: all .3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--accent-pink);
            box-shadow: 0 0 0 4px rgba(255, 92, 168, .15);
        }

        .error-message {
            color: #e63c76;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 500;
            display: block;
        }

        .remember-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: var(--plum-mid);
            cursor: pointer;
            font-weight: 500;
        }

        .checkbox-label input {
            margin-right: 8px;
            accent-color: var(--accent-pink);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot {
            font-size: 13px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: .2s;
        }

        .forgot:hover {
            color: var(--accent-pink);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-plum) 0%, var(--plum-mid) 50%, var(--accent-pink) 100%);
            color: white;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            box-shadow: 0 10px 20px rgba(93, 51, 64, 0.15);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(255, 92, 168, 0.3);
        }

        .status-alert {
            background-color: var(--soft-pink);
            color: var(--primary-plum);
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 500;
            border: 1px solid rgba(255, 92, 168, 0.2);
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-card">

        <div class="login-title">Welcome Back</div>
        <div class="login-sub">Login to your SerbaSerbi dashboard</div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Input -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" 
                       type="email" 
                       name="email" 
                       class="form-control-custom" 
                       value="{{ old('email') }}" 
                       placeholder="name@example.com"
                       required 
                       autofocus>
                
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" 
                       type="password" 
                       name="password" 
                       class="form-control-custom" 
                       placeholder="••••••••"
                       required>
                
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="remember-flex">
                <label class="checkbox-label" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">
                Log In
            </button>

        </form>

    </div>

</body>
</html>