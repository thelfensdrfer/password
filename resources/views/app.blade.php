<!DOCTYPE html>
<html>
    <head></head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/main.css" />
    </head>
    <body>
        <!-- Wrapper -->
        <div id="wrapper">

            <!-- Header -->
            <header id="header">
                <div class="inner">
                    <!-- Logo -->
                    <a href="/" class="logo">
                        <span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">@yield('title')</span>
                    </a>
                </div>
            </header>

            <!-- Main -->
            <div id="main">
                <div class="inner">
                    <section>
                        @yield('content')
                    </section>
                </div>
            </div>

            <!-- Footer -->
            <footer id="footer">
                <div class="inner">
                    <ul class="copyright">
                        <li>&copy; 2017-{{ date('Y') }} Tim Helfensdörfer - <a href="https://thelfensdrfer.de/impressum.html">Impressum</a></li> - <a href="https://thelfensdrfer.de/datenschutz.html">Datenschutzerklärung</a>
                    </ul>
                </div>
            </footer>
        </div>
    </body>
</html>
