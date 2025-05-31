@extends('layouts.app')

@section('content')
<style>
    .green-gradient-bg {
        background: linear-gradient(to right, #a8e063, #56ab2f); /* Dégradé vert */
    }
    .centered-img {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%; /* Ensure height is 100% of parent */
    }
</style>
<div class="container-fluid"> {{-- Use container-fluid for full width --}}
    <div class="min-vh-100" style="display: flex; justify-content: center; align-items: center; background-color: #f0f0f0;"> {{-- min-vh-100 for full viewport height --}}

        {{-- Left Column: Image and Green Gradient Background --}}
        <div class="green-gradient-bg p-4" style="width: 30%; height: 500px; display: flex; justify-content: center; align-items: center;"> {{-- Added flex classes and padding --}}
            <img src="{{ asset('images/pharmacie.png') }}" alt="Pharmacy Image" style="width: 200px; height: auto;"> {{-- Centered image with fixed width --}}
        </div>

        {{-- Right Column: Login Form --}}
        <div  style="width: 30%; height: 500px; display: flex; justify-content: center; align-items: center;"> {{-- Added flex classes and padding --}}
            <div class="card shadow-lg w-100" style="width: 100%; height: 500px;"> {{-- Added w-100 and max-width --}}
                <div class="card-body p-5"> {{-- Added padding --}}
                    <div class="text-center mb-4"> {{-- Container for centered icon --}}
                        <img src="{{ asset('images/profil-de-lutilisateur.png') }}" alt="Profile Icon" style="width: 80px; height: auto;"> {{-- Profile icon --}}
                    </div>
                    <h2 class="text-center mb-4">{{ __('Login') }}</h2> {{-- Centered title --}}

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        <div class="d-grid gap-2 mt-4"> {{-- Added margin top --}}
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
