@extends('layouts.app')

@section('content')
<div class="container">
    <form class="form-horizontal form-signin" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputEmail" class="sr-only">Email address</label>

        <div>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email address" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div>
                <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary" style="margin-right: 5%">
                    Sign in
                </button>

                <a href="{{ route('register') }}">
                    New User? Register
                </a>
            </div>
        </div>
      </form>

</div>
@endsection
