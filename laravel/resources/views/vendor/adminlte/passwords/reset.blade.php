@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.password_reset_message') }}</p>
            <form action="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group has-feedback {{ $errors->has('tx_email') ? 'has-error' : '' }}">
                    <input type="tx_email" name="tx_email" class="form-control" value="{{ $tx_email or old('tx_email') }}" 
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('tx_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tx_email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('tx_password') ? 'has-error' : '' }}">
                    <input type="password" name="tx_password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('tx_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tx_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('tx_password_confirmation') ? 'has-error' : '' }}">
                    <input type="password" name="tx_password_confirmation" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
                    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    @if ($errors->has('tx_password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tx_password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit"
                        class="btn btn-poli btn-block btn-flat"
                >{{ trans('adminlte::adminlte.reset_password') }}</button>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop
