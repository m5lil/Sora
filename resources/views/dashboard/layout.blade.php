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


        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="content has-text-centered">
                    <p>
                    <strong>Codzin</strong> is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC ANS 4.0</a>.
                    </p>
                </div>
            </div>
        </footer>

         @stack('scripts')

    </body>
</html>
