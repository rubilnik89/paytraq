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
                <form action="{{ route('update_finans') }}">
                    <label for="contract_number">Contract Number</label><input name="contract_number" id="contract_number" required><br>
                    <label for="credit_limit">Credit Limit</label><input name="credit_limit" id="credit_limit"><br>
                    <label for="deposit">Deposit</label><input name="deposit" id="deposit"><br>
                    <label for="discount">Discount</label><input name="discount" id="discount"><br>
                    <label for="pay_term_type">Pay Term Type</label><input name="pay_term_type" id="pay_term_type"><br>
                    <label for="pay_term_days">Pay Term Days</label><input name="pay_term_days" id="pay_term_days"><br>
                    <label for="products_tax_key_id">Products Tax Key ID</label><input name="products_tax_key_id" id="products_tax_key_id"><br>
                    <label for="services_tax_key_id">Services Tax Key ID</label><input name="services_tax_key_id" id="services_tax_key_id"><br>
                    <label for="wrhID">WrhID</label><input name="wrhID" id="wrhID"><br>
                    <label for="price_group_id">Price Group id</label><input name="price_group_id" id="price_group_id"><br>
                    <button>Отправить</button>
                </form>
            {{--</div>--}}
        {{--</div>--}}
    </body>
</html>
