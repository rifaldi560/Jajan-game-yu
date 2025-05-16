@php use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; @endphp

@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #1b2838;
        color: #fff;
    }

    .card {
        background-color: #2a3b4c;
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
    }

    .card-header {
        background-color: #16222e;
        color: #fff;
        font-weight: bold;
        border-bottom: 1px solid #3c4f63;
    }

    label {
        color: #ccc;
    }

    .form-control {
        background-color: #1e2b38;
        color: #fff;
        border: 1px solid #3c4f63;
    }

    .form-control:focus {
        border-color: #66afe9;
        background-color: #243447;
        color: #fff;
    }

    .form-check-label {
        color: #ccc;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-link {
        color: #66afe9;
    }

    .btn-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header text-center">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">
                                {{ __('Email Address') }}
                            </label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                {{ __('Password') }}
                            </label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert --}}
@if (session('status'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('status') }}",
            icon: "success",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            toast: true,
            position: 'top-end'
        });
    </script>
@endif
@endsection
