@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="card my-card">

                <div class="card-body my-card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="form-group my-form-group row">
    
                                <a  href='{{url("login/facebook")}}' style="  padding: 1em 2em;margin-bottom: 50px  "class=" btn btn-primary">
                                    <i class="fa fa-facebook"></i> სეისბურგით შესვლა
                                </a>

                        </div>

                        <div class="form-group my-form-group row">
                            <label for="email" class="">{{ __('მეილი') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group my-form-group row">
                            <label for="password" class="">{{ __('პაროლი') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group my-form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('დამიმახსოვრე') }}
                                    </label>
                                </div>
                        </div>

                        <div class="form-group my-form-group row mb-0">
                                <button type="submit" style="width: 100%" class="btn btn-secondary">
                                    {{ __('შესვლა') }}
                                </button>

            
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('პაროლის დავიწყება არ მუშაობს ალბათ?') }}
                                    </a>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
