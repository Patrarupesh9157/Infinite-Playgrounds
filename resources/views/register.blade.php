@extends('layouts.app')

@section('title', 'Register - Lugx Gaming')

@section('content')
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Register</h3>
                <span class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a> > Register
                </span>
            </div>
        </div>
    </div>
</div>

<div class="register-page section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="register-form">
                    <div class="section-heading">
                        <h6>Join Us</h6>
                        <h2>Create Your Account</h2>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf
                        <div class="mb-4">
                            <fieldset>
                                <input type="text" name="name" id="name" 
                                       placeholder="Full Name"
                                       value="{{ old('name') }}" 
                                       class="@error('name') is-invalid @enderror"
                                       required autofocus>
                            </fieldset>
                        </div>

                        <div class="mb-4">
                            <fieldset>
                                <input type="email" name="email" id="email" 
                                       placeholder="Email Address"
                                       value="{{ old('email') }}" 
                                       class="@error('email') is-invalid @enderror"
                                       required>
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

                        <div class="mb-4">
                            <fieldset>
                                <input type="password" name="password_confirmation" 
                                       id="password_confirmation" 
                                       placeholder="Confirm Password"
                                       required>
                            </fieldset>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="orange-button">Register</button>
                        </div>

                        <div class="text-center">
                            <p>Already have an account? 
                                <a href="{{ route('login') }}" class="login-link">Login Now</a>
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
    .register-form {
        background: #fff;
        padding: 40px;
        border-radius: 23px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.05);
    }
    .register-form input {
        width: 100%;
        height: 50px;
        border: 1px solid #eee;
        border-radius: 23px;
        padding: 0px 25px;
        font-size: 14px;
        margin-bottom: 10px;
    }
    .login-link {
        color: #ee626b;
        text-decoration: none;
    }
    .login-link:hover {
        color: #dc3545;
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