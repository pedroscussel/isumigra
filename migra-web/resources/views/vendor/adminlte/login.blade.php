@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/iCheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'login-page')

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}"><img src="images/migra_logo.png" width="200px"></a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.login_message') }}</p>
            <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post"
                id="form-login">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" name="password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
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
                        <button type="submit"
                                class="btn btn-primary btn-sm btn-block btn-flat">{{ trans('adminlte::adminlte.sign_in') }}</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"
                   class="text-center"
                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>
                <br>
                @if (config('adminlte.register_url', 'register'))
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}"
                       class="text-center"
                    >{{ trans('adminlte::adminlte.register_a_new_membership') }}</a>
                @endif
            </div>
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/plugins/iCheck/icheck.min.js') }}"></script>
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


    <!-- @TODO: remover essa parte pois é apenas para testar níveis de usuários -->
    <script>
        $("#debug-user").change(function(){
            var optionSelected = $("#debug-user", this);
            var valueSelected = this.value;

            switch($('#debug-user option:selected').val()) {
            case "Administrador MIGRA":
                $("input[type=email]").val("admin@migra.ind.br");
                $("input[type=password]").val("admin");
                break;
            case "Operador MIGRA":
                $("input[type=email]").val("ope@migra.ind.br");
                $("input[type=password]").val("operator");
                break;
            case "Gerente MIGRA":
                $("input[type=email]").val("manager@migra.ind.br");
                $("input[type=password]").val("gerente");
                break;
            case "Comercial MIGRA":
                $("input[type=email]").val("comercial@migra.ind.br");
                $("input[type=password]").val("comercial");
                break;
            case "Administrador CLIENTE":
                $("input[type=email]").val("admin@tecnova.ind.br");
                $("input[type=password]").val("admin");
                break;
            case "Operador CLIENTE":
                $("input[type=email]").val("ope@tecnova.ind.br");
                $("input[type=password]").val("123456");
                break;
            case "Gerente CLIENTE":
                $("input[type=email]").val("dir@tecnova.ind.br");
                $("input[type=password]").val("123456");
                break;
            case "Comercial CLIENTE":
                $("input[type=email]").val("com@tecnova.ind.br");
                $("input[type=password]").val("123456");
                break;
            case "Cliente simples":
                $("input[type=email]").val("cli@tecnova.ind.br");
                $("input[type=password]").val("123456");
                break;
            case "Operador Fictícia A":
                $("input[type=email]").val("op@a.com");
                $("input[type=password]").val("operador");
                break;
            }

            $("#form-login").submit();
        });

    </script>
    <!-- ---------------------------------------------------------------------- -->


@stop
