<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>paytraq</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        {{--<style>--}}
            {{--html, body {--}}
                {{--background-color: #fff;--}}
                {{--color: #636b6f;--}}
                {{--font-family: 'Raleway', sans-serif;--}}
                {{--font-weight: 100;--}}
                {{--height: 100vh;--}}
                {{--margin: 0;--}}
            {{--}--}}

            {{--.full-height {--}}
                {{--height: 100vh;--}}
            {{--}--}}

            {{--.flex-center {--}}
                {{--align-items: center;--}}
                {{--display: flex;--}}
                {{--justify-content: center;--}}
            {{--}--}}

            {{--.position-ref {--}}
                {{--position: relative;--}}
            {{--}--}}

            {{--.top-right {--}}
                {{--position: absolute;--}}
                {{--right: 10px;--}}
                {{--top: 18px;--}}
            {{--}--}}

            {{--.content {--}}
                {{--text-align: center;--}}
            {{--}--}}

            {{--.title {--}}
                {{--font-size: 84px;--}}
            {{--}--}}

            {{--.links > a {--}}
                {{--color: #636b6f;--}}
                {{--padding: 0 25px;--}}
                {{--font-size: 12px;--}}
                {{--font-weight: 600;--}}
                {{--letter-spacing: .1rem;--}}
                {{--text-decoration: none;--}}
                {{--text-transform: uppercase;--}}
            {{--}--}}

            {{--.m-b-md {--}}
                {{--margin-bottom: 30px;--}}
            {{--}--}}
        {{--</style>--}}
    </head>
    <body>
        {{--<div class="flex-center position-ref full-height">--}}
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            {{--<div class="content">--}}
                <form action="{{ route('register') }}">
                    <label for="name">Name</label><input name="name" id="name" required><br>
                    <label for="email">Email</label><input name="email" id="email"><br>
                    <label for="type">Type</label><input name="type" id="type"><br>
                    <label for="status">Status</label><input name="status" id="status"><br>
                    <label for="reg_number">Reg number</label><input name="reg_number" id="reg_number"><br>
                    <label for="vat_number">Vat number</label><input name="vat_number" id="vat_number"><br>
                    <label for="address">Address</label><input name="address" id="address"><br>
                    <label for="zip">Zip</label><input name="zip" id="zip"><br>
                    <label for="country">Country</label><input name="country" id="country"><br>
                    <label for="phone">Phone</label><input name="phone" id="phone"><br>
                    <label for="group_id">Group id</label><input name="group_id" id="group_id"><br>
                    <button>Отправить</button>
                </form>
            {{--</div>--}}
        {{--</div>--}}
    </body>
</html>
