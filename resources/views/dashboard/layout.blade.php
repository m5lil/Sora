<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'codzin') }}</title>

        <!-- Fonts -->
        <link href="{{ elixir('css/app.css') }}" rel='stylesheet' type='text/css'>
        <link href="{{ elixir('css/sweetalert2.css') }}" rel='stylesheet' type='text/css'>


    </head>
    <body>
        <section class="hero is-primary is-bold">
            <div class="hero-body">
                <div class="container">
                <h1 class="title">
                    Dashboard
                </h1>
                <h2 class="subtitle">
                    Deh ElDashboard Ya Bashet Elbashwat
                </h2>
                </div>
            </div>
        </section>

        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="content has-text-centered">
                    <p>
                    <strong>Bulma</strong> by <a href="http://jgthms.com">Jeremy Thomas</a>. The source code is licensed
                    <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
                    is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC ANS 4.0</a>.
                    </p>
                    <p>
                    <a class="icon" href="https://github.com/jgthms/bulma">
                        <i class="fa fa-github"></i>
                    </a>
                    </p>
                </div>
            </div>
        </footer>

         @stack('scripts')

    </body>
</html>
