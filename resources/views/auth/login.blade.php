@extends('layouts.auth')

@section('content')

<p class="login-box-msg">Авторизация</p>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" required placeholder="username" value="{{ old('username') }}" autofocus autocomplete="username">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="input-group mb-3">
        <input type="password"  name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <div class="row">
        <div class="col-8">
            <div class="icheck-primary">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Login') }}
            </button>


        </div>
        <!-- /.col -->
    </div>
</form>
@endsection
