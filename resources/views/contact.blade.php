@extends('layouts.app')

@section('title', 'Contact Us - Infinite Playgrounds')

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Contact Us</h3>
                    <span class="breadcrumb">
                        <a href="{{ route('home') }}">Home</a> > Contact Us
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-page section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text">
                        <div class="section-heading">
                            <h6>Contact Us</h6>
                            <h2>Say Hello!</h2>
                        </div>
                        <p>Infinite Playgrounds is designed to be a haven for gamers of all ages and interests. With a vast collection of games spanning multiple genres such as action, adventure, simulation, puzzle, strategy, and multiplayer, players can explore endless possibilities and find something they love. </p>
                        <ul>
                            <li><span>Address</span> Surat, Gujrat, India</li>
                            <li><span>Phone</span> +91 99044 68811</li>
                            <li><span>Email</span> infinite@contact.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3720.945351763306!2d72.80790317503511!3d21.154572980526428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f8e2963d9bf%3A0x3969ed23dfbd5538!2sSuman%20Parth!5e0!3m2!1sen!2sin!4v1735631305868!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                @if(session('success'))
                                    <div class="alert alert-success mt-4">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger mt-4">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form id="contact-form" action="{{ route('contact.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <fieldset>
                                                <input type="text" name="name" id="name" 
                                                       placeholder="Your Name..." 
                                                       value="{{ old('name') }}"
                                                       class="@error('name') is-invalid @enderror"
                                                       required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset>
                                                <input type="text" name="surname" id="surname" 
                                                       placeholder="Your Surname..." 
                                                       value="{{ old('surname') }}"
                                                       class="@error('surname') is-invalid @enderror"
                                                       required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset>
                                                <input type="email" name="email" id="email" 
                                                       placeholder="Your E-mail..." 
                                                       value="{{ old('email') }}"
                                                       class="@error('email') is-invalid @enderror"
                                                       required>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-6">
                                            <fieldset>
                                                <input type="text" name="subject" id="subject" 
                                                       placeholder="Subject..." 
                                                       value="{{ old('subject') }}"
                                                       class="@error('subject') is-invalid @enderror">
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <textarea name="message" id="message" 
                                                          placeholder="Your Message"
                                                          class="@error('message') is-invalid @enderror"
                                                          required>{{ old('message') }}</textarea>
                                            </fieldset>
                                        </div>
                                        <div class="col-lg-12">
                                            <fieldset>
                                                <button type="submit" id="form-submit" class="orange-button">
                                                    Send Message Now
                                                </button>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .contact-page input.is-invalid,
    .contact-page textarea.is-invalid {
        border-color: #dc3545;
    }
    
    .alert {
        border-radius: 15px;
        padding: 15px 20px;
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
</style>
@endpush