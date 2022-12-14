<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title> Đăng nhập | Vnua Job </title>
    <meta property="og:title" content="Sign In">
    <meta name="author" content="Beni Arisandi">
    <meta property="og:locale" content="en_US">
    <meta name="description" content="Responsive admin theme build on top of Bootstrap 4">
    <meta property="og:description" content="Responsive admin theme build on top of Bootstrap 4">
    <link rel="canonical" href="https://uselooper.com">
    <meta property="og:url" content="https://uselooper.com">
    <meta property="og:site_name" content="Looper - Bootstrap 4 Admin Theme">
    <script type="application/ld+json">
      {
        "name": "Looper - Bootstrap 4 Admin Theme",
        "description": "Responsive admin theme build on top of Bootstrap 4",
        "author":
        {
          "@type": "Person",
          "name": "Beni Arisandi"
        },
        "@type": "WebSite",
        "url": "",
        "headline": "Sign In",
        "@context": "http://schema.org"
      }
    </script><!-- End SEO tag -->
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('backend')}}/assets/apple-touch-icon.png">
    <link rel="shortcut icon" href="{{asset('backend')}}/assets/favicon.ico">
    <meta name="theme-color" content="#3063A0"><!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End Google font -->
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="{{asset('backend')}}/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css"><!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="{{asset('backend')}}/assets/stylesheets/theme.min.css" data-skin="default">
    <link rel="stylesheet" href="{{asset('backend')}}/assets/stylesheets/theme-dark.min.css" data-skin="dark">
    <link rel="stylesheet" href="{{asset('backend')}}/assets/stylesheets/custom.css">
    <script>
        var skin = localStorage.getItem('skin') || 'default';
        var isCompact = JSON.parse(localStorage.getItem('hasCompactMenu'));
        var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        // Disable unused skin immediately
        disabledSkinStylesheet.setAttribute('rel', '');
        disabledSkinStylesheet.setAttribute('disabled', true);
        // add flag class to html immediately
        if (isCompact == true) document.querySelector('html').classList.add('preparing-compact-menu');
    </script><!-- END THEME STYLES -->
</head>
<body>
<!--[if lt IE 10]>
<div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
<![endif]-->
<!-- .auth -->
<main class="auth auth-floated">
    <!-- form -->
    <form class="auth-form" action="{{ route('loginProcess') }}" method="post">
        @csrf
        <div class="mb-4">
            <div class="mb-3">
                <img class="rounded" src="{{asset('backend')}}/assets/apple-touch-icon.png" alt="" height="72">
            </div>
            <h1 class="h3"> Sign In </h1>
        </div>
        </p><!-- .form-group -->
        <div class="form-group mb-4">
            <label class="d-block text-left" for="inputUser">Email</label> <input type="email" id="inputUser" name='email' class="form-control form-control-lg" required="" autofocus="">
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group mb-4">
            <label class="d-block text-left" for="inputPassword">Mật khẩu</label> <input type="password" name='password' id="inputPassword" class="form-control form-control-lg" required="">
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group mb-4">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <div class="form-group text-center">
            <div class="custom-control custom-control-inline custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="remember-me"> <label class="custom-control-label" for="remember-me">Lưu đăng nhập</label>
            </div>
        </div><!-- /.form-group -->
        <!-- recovery links -->
        <p class="py-2">
            <a href="auth-recovery-password.html" class="link">Quên mật khẩu?</a>
        </p><!-- /recovery links -->
        <!-- copyright -->
        <p class="mb-0 px-3 text-muted text-center"> © 2018 Phùng xuân thực
        </p>
    </form><!-- /.auth-form -->
    <!-- .auth-announcement -->
    <div id="announcement" class="auth-announcement" style="background-image: url({{asset('backend')}}/assets/images/illustration/img-1.png);">
        <div class="announcement-body">
            <h2 class="announcement-title"> How to Prepare for an Automated Future </h2><a href="#" class="btn btn-warning"><i class="fa fa-fw fa-angle-right"></i> Check Out Now</a>
        </div>
    </div><!-- /.auth-announcement -->
</main><!-- /.auth -->
<!-- BEGIN BASE JS -->
<script src="{{asset('backend')}}/assets/vendor/jquery/jquery.min.js"></script>
<script src="{{asset('backend')}}/assets/vendor/popper.js/umd/popper.min.js"></script>
<script src="{{asset('backend')}}/assets/vendor/bootstrap/js/bootstrap.min.js"></script> <!-- END BASE JS -->
<!-- BEGIN PLUGINS JS -->
<script src="{{asset('backend')}}/assets/vendor/particles.js/particles.js"></script>
<script>
    /**
     * Keep in mind that your scripts may not always be executed after the theme is completely ready,
     * you might need to observe the `theme:load` event to make sure your scripts are executed after the theme is ready.
     */
    $(document).on('theme:init', () =>
    {
        /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
        particlesJS.load('announcement', '{{asset('backend')}}/assets/javascript/pages/particles.json');
    })
</script> <!-- END PLUGINS JS -->
<!-- BEGIN THEME JS -->
<script src="{{asset('backend')}}/assets/javascript/theme.min.js"></script> <!-- END THEME JS -->
</body>
</html>
