<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Application</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="bg-light py-2 px-3 border-bottom d-flex justify-content-end">
            @if (Route::has('login'))
                <div>
                    @auth
                        <a href="{{ url('/home') }}" class="text-secondary">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-secondary">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-3 text-secondary">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </body>
</html>
