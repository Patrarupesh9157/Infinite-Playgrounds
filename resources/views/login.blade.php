@extends('layouts.app')

@section('title', 'Login - Lugx Gaming')

@section('content')
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Login</h3>
                <span class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a> > Login
                </span>
            </div>
        </div>
    </div>
</div>

<div class="login-page section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-form">
                    <div class="section-heading">
                        <h6>Welcome Back</h6>
                        <h2>Login to Your Account</h2>
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-4">
                            <fieldset>
                                <input type="email" name="email" id="email" 
                                       placeholder="Email Address"
                                       value="{{ old('email') }}" 
                                       class="@error('email') is-invalid @enderror"
                                       required autofocus>
                            </fieldset>
                        </div>

                        <div class="mb-4">
                            <fieldset>
                                <input type="password" name="password" id="password" 
                                       placeholder="Password"
                                       class="@error('password') is-invalid @enderror"
                                       required>
                            </fieldset>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" 
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="orange-button">Login</button>
                        </div>

                        <div class="text-center">
                            <p>Don't have an account? 
                                <a href="{{ route('register') }}" class="register-link">Register Now</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .login-form {
        background: #fff;
        padding: 40px;
        border-radius: 23px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.05);
    }
    .login-form input {
        width: 100%;
        height: 50px;
        border: 1px solid #eee;
        border-radius: 23px;
        padding: 0px 25px;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .register-link {
        color: #ee626b;
        text-decoration: none;
    }
    .register-link:hover {
        color: #dc3545;
    }
    .form-check-input {
        width: auto !important;
        height: auto !important;
        margin-right: 10px;
    }
    .orange-button {
        display: inline-block;
        padding: 12px 30px;
        background-color: #ee626b;
        color: #fff;
        border-radius: 25px;
        border: none;
        font-weight: 500;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        width: 100%;
    }
    .orange-button:hover {
        background-color: #dc3545;
        color: #fff;
    }
</style>
@endpush