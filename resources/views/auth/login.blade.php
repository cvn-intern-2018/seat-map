@extends("layouts.app")
@section("scripts")
<link rel="stylesheet" href="{{ asset("/css/login.css") }}">
@endsection
@section("content")
<link rel="stylesheet" href="{{ asset("/css/login.css") }}">
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="row">
        <div class="col-md-3 logo-login">
          <img src="{{ asset("/images/logo-square.png") }}" alt="" class="img-responsive">
        </div>
        <div class="col-md-9">
          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            @if(session()->has('login_error') || $errors->has('identity') || $errors->has('password'))
              <div class="alert alert-warning">
                @if(session()->has('login_error'))
                <span class="help-block">
                  {{ session()->pull('login_error') }}
                </span>
                @endif
                @if ($errors->has('identity'))
                <span class="help-block">
                  {{ $errors->first('identity') }}
                </span>
                @endif
                @if ($errors->has('password'))
                <span class="help-block">
                  {{ $errors->first('password') }}
                </span>
                @endif
              </div>
            @endif
            <div class="form-group{{ $errors->has('identity') ? ' has-error' : '' }}">
              <label for="identity" class="col-md-4 control-label">Email or Username</label>

              <div class="col-md-6">
                <input id="identity" type="identity" class="form-control" name="identity" value="{{ old('identity') }}" autofocus required>
              </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Password</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Login
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection