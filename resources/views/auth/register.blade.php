@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="card my-card">

                <div class="card-body my-card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf


                        <div class="form-group my-form-group row">
    
                            <a  href='{{url("login/facebook")}}' style="  padding: 1em 2em;margin-bottom: 50px  "class=" btn btn-primary">
                                <i class="fa fa-facebook"></i> სეისბურგით შესვლა
                            </a>

                        </div>
                        <div class="form-group my-form-group row">
                            <label for="name" >{{ __('სახელი და გვარი') }}</label>

                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group my-form-group row">
                            <label for="email" >{{ __('მეილი') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group my-form-group row">
                            <label for="password" >{{ __('პაროლი') }}</label>

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group my-form-group row">
                            <label for="password-confirm" >{{ __('გაიმეორე პაროლი') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="form-group my-form-group row ">
                                <button type="submit" style="width:100%" class="btn btn-secondary">
                                    {{ __('რეგისტრაცია') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>
@endsection
