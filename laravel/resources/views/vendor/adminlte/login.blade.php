@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/css/auth.css') }}">
    @yield('css')
@endsection

@section('body_class', 'login-page')

@section('content_header')
<div class="header" style="display: flex; flex-wrap:wrap; align-items:center; border-bottom: 2px solid black;margin: 0 15vh 0 15vh">
			<h5>
            <span>PMHT - Planilha Mensal de Horas Trabalhadas</span>
			<a href="http://www.politecnica-eng.com.br/" style="margin-left: auto">©2018-2019 Politecnica Engenharia LTDA
			<img alt="Politecnica" src="./img/logo_laravel.png" width="48" height="48">
			</a>
            </h5>
		</div>
@endsection

@section('body')
    <div class="login-box">
        <div class="login-logo">
            
            
        </div>
        <!-- /.login-logo -->

        <div class="login-box-body" style="margin: 25vh 0 0 0">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.login_message') }}</p>

            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('tx_email') ? 'has-error' : '' }}">
                    <input type="email" name="tx_email" class="form-control" value="{{ old('tx_email') }}"
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
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> {{ trans('adminlte::adminlte.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-poli btn-block btn-flat">
                            Entrar
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                   class="text-center">
                       Esqueci minha Senha
                   </a>
                <br>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@endsection

@section('adminlte_js')
    <script src="{{ asset('adminlte/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    @yield('js')
@endsection
