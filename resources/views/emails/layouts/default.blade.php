<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size: 14px;line-height: 1.42857143;color:#555555;background:#333">
<div style="width:600px;margin:auto;background:#eeeeee;">
    <div style="background:#eae9e7;padding:30px 0; text-align: center;">
        {!! \App\Library\Common::getLogo() !!}
    </div>
    <div style="margin:0 30px;">
        @yield('content')
    </div>
    <div style="background:#eae9e7;border-top:1px solid #d6d6d6;text-align:center;margin-top:30px;padding-bottom:15px;">
        <p style="font-size:13px;"><a href="{{{ $settings->web }}}">{{{ $settings->meta_baslik }}}</a></p>
    </div>
</div>
</body>
</html>
