<!DOCTYPE html>
<html>

<head>
    <title>{!! \App\Setting::find(1)->meta_baslik !!} Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{!! \App\Setting::find(1)->meta_baslik !!} Yönetim Paneli">
    <meta name="author" content="dalyabilisim">
    <!-- global level css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- end of global level css -->
    <!-- page level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/login.css') }}" />
    <!-- end of page level css -->

</head>

<body>
    <div class="container">
        <div class="row vertical-offset-100">
            <!-- Notifications -->
            @include('notifications')

            <div class="col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div id="container_demo">
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <a class="hiddenanchor" id="toforgot"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form action="{{ route('signin') }}" autocomplete="on" method="post" role="form">
                                <h3>
                                    {!! \App\Library\Common::getLogo() !!}
                                </h3>
                                    <!-- CSRF Token -->
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="email" class="uname control-label"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        E-Mail
                                    </label>
                                    <input id="email" name="email" required type="email" placeholder="" value="{{{ Input::old('email') }}}" />
                                    <div class="col-sm-12">
                                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        Şifre
                                    </label>
                                    <input id="password" name="password" required type="password" placeholder="" />
                                    <div class="col-sm-12">
                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <p class="keeplogin">
                                    <input type="checkbox" name="remember-me" id="remember-me" value="remember-me" />
                                    <label for="remember-me">Beni Hatırla</label>
                                </p>
                                <p class="login button">
                                    <input type="submit" value="Giriş" class="btn btn-success" />
                                </p>
                                <p class="change_link">
                                    <a href="#toforgot">
                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Şifremi Unuttum</button>
                                    </a>
                                </p>
                            </form>
                        </div>
                        <div id="forgot" class="animate form">
                            <form action="{{ route('forgot-password') }}" autocomplete="on" method="post" role="form">
                                <h3>
                                    {!! \App\Library\Common::getLogo() !!}<br>
                                    Şifre Hatırlatma
                                </h3>
                                <p>
                                    Sistemde kayıtlı mail adresinizi giriniz. Şifrenizi resetleme linki gönderilecektir.
                                </p>

                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="emailsignup1" class="youmai">
                                        <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        E-Mail Adresi
                                    </label>
                                    <input id="email" name="email" required type="email" placeholder="your@mail.com" value="{{{ Input::old('email') }}}" />
                                    <div class="col-sm-12">
                                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <p class="login button">
                                    <input type="submit" value="Gönder" class="btn btn-success" />
                                </p>
                                <p class="change_link">
                                    <a href="#tologin" class="to_register">
                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Geri</button>
                                    </a>
                                </p>
                            </form>
                        </div>

                    </div>
                    <div style="text-align: center; font-size: 11px; color:#666;">&copy; 2017-{{ date('Y') }} bakkal.qa<br>Her Hakkı Saklıdır.</div>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}"></script>
    <!-- end of global js -->
</body>
</html>