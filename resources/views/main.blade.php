<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>paytraq</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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


            <div class="row">
                <div class="col-sm-4 photo" style="height: 350px; background-color: #245269">фото</div>
                <div class="col-sm-4 descr" style="height: 350px; background-color: #2ab27b">описание товара</div>
            </div>
            <div class="row">
                <div class="col-sm-4" style="height: 400px; background-color: #5bc0de">
                    <div class="row">
                    <div class="col-sm-6" style="background-color: #f2dede">
                        <div id="0" class="cat">Все товары</div>
                        @foreach($product_groups['Group'] as $group)
                            <div id="{{ $group['GroupID'] }}" class="cat" style="border: solid 1px">{{ $group['GroupName']}}</div>
                        @endforeach
                    </div>
                    <div id="products" class="col-sm-6" style="background-color: #9BA2AB">
                        @foreach($products['Product'] as $product)
                            <div id="{{ $product['ItemID'] }}" class="product" data-qty="{{ round($product['Inventory']['Qty']) }}">{{ $product['Name'] . ' ' .  round($product['Inventory']['Qty']) . ' шт.' }}</div>
                        @endforeach
                    </div>
                    </div>
                </div>
                <div class="col-sm-4" id="order" style="height: 400px; background-color: #245269">
                    <table border="1" style="border-collapse: collapse">
                        <tr>
                            <td>Название</td>
                            <td colspan="2">Количество</td>
                            <td>Доставка</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="2"></td>
                            <td>Доступно Прага</td>
                            <td></td>
                            <td>10</td>
                            <td>Добавить</td>
                        </tr>
                        <tr>
                            <td>Доступно Армения</td>
                            <td>1000</td>
                            <td>30</td>
                            <td>Добавить</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4" style="height: 400px; background-color: #9BA2AB">
                    <table border="1" id="table_send" style="border-collapse: collapse">
                        <tr>
                            <td>Наименование</td>
                            <td>Количество</td>
                            <td>Доставка</td>
                            <td>Цена</td>
                            <td>Сумма</td>
                            <td>Удалить</td>
                        </tr>
                    </table>
                    Total sum: <input readonly value="0" id="total">
                    <a id="send_link" href="">Отправить заказ</a>
                </div>
        </div>


        <script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
        <script>
            $('.cat').click(function () {
                var thisId = $(this).attr('id');
                $.ajax({
                    method: 'GET',
                    url: "/group_products/" + thisId,
                    success: function(res){
                        $("#products").empty();
                        for(var i = 0; i < res.Product.length; i++){
                            $("#products").append('<div id="' + res.Product[i].ItemID + '" class="product" data-qty="' + Math.round(res.Product[i].Inventory.Qty) + '">' + res.Product[i].Name + ' ' + Math.round(res.Product[i].Inventory.Qty) + ' шт.</div>');
                        }

                        $("#products").children().click(function () {
                            ShowProduct($(this));
                        });
                    }
                });


            });

            $('.product').click(function () {
                ShowProduct($(this));
            });

            function ShowProduct(self) {
                var thisId = self.attr('id');
                var qty = self.data('qty');
                $.ajax({
                    method: 'GET',
                    url: "/get_product/" + thisId,
                    data:  qty,
                    success: function(res){
                        var price = (res.Prices.Price != undefined ? res.Prices.Price[2]['Amount'] : 0)
                        $(".descr").empty().append('<div class="col-sm-4">Наименование товара</div><div class="col-sm-8">' + res.Name + '</div>' +
                            '<div class="col-sm-4">Описание товара</div><div class="col-sm-8">' + res.Description + '</div>' +
                            '<div class="col-sm-4">Артикул</div><div class="col-sm-8">' + res.Code + '</div>' +
                            '<table border="1" style="border-collapse: collapse" class="order_table"> <tr> <td rowspan="3">Условия поставки по складам</td> <td></td> <td>Количество</td> <td>Срок поставки</td> </tr>' +
                            '<tr> <td>Армения</td> <td id="amount_armenia">1000</td> <td>30</td> </tr>' +
                            '<tr>  <td>Прага</td> <td id="amount_praha">' + qty + '</td> <td>10</td> </tr> </table>'+
                            '<div class="col-sm-4">Брендирование</div><div class="col-sm-8">s</div>' +
                            '<div class="col-sm-4">Цена без НДС</div><div class="col-sm-8">' + price + ' EUR</div>');
                        if('image' in res) {
                            $(".photo").empty().append('<img src="data:image/jpg;charset=utf8;base64,' + res.image + '" />');
                        } else {
                            $(".photo").empty().append('<img src="{{ asset('no_image.png') }}" />');
                        }
                        $('#order').empty().append(
                            '<table class="order2" border="1" style="border-collapse: collapse"> <tr> <td>Название</td> <td colspan="2">Количество</td> <td>Доставка</td> <td></td> </tr>' +
                            '<tr> <td rowspan="2">' + res.Name + '</td> <td>Доступно Прага</td> <td><input class="editable_value10" type="text" value="'+qty+'"></td> <td>10</td> <td class="add_button" data-id="amount_praha">Добавить</td> </tr>' +
                            '<tr> <td>Доступно Армения</td> <td><input class="editable_value30" type="text" value="1000"></td> <td>30</td> <td class="add_button" data-id="amount_armenia">Добавить</td> </tr> </table>'
                        );
                        $(".add_button").click(function () {
                            var country = $(this).data('id');
                            var days = country == 'amount_armenia' ? 30 : 10;
                            var amount = $('.order2').find('.editable_value' + days).val();
                            if($("tr").is('#order' + res.ItemID) && ($('.days' + res.ItemID + days).text() == days))//если такой элемент добавили с таким же кол-вом дней доставки
                            {
                                $('.days' + res.ItemID + days).parent().find('.amount' + res.ItemID + days).text((+$('.days' + res.ItemID + days).parent().find('.amount' + res.ItemID + days).text()) + +amount)
                            } else {
                                $('#table_send').append(
                                    '<tr id="order' + res.ItemID + '"> <td>' + res.Name + '</td> <td class="amount' + res.ItemID + days +'">' + amount + '</td> <td class="days' + res.ItemID + days +'">' + days + '</td> <td>' + price + ' EUR</td> <td class="cost' + res.ItemID + days + '">' + (price * amount) + '</td> <td class="del">x</td> </tr>'
                                );
                            }

                            $('#total').val((+($('#total').val()) + (+(price) * +(amount))));

                            $('.del').click(function () {
                                var totalsum = +$('#total').val();
                                $('#total').val(+totalsum - +$(this).parent().find('.cost' + res.ItemID + days).text());
                                $(this).parent().remove();
                            });
                        });

                        $('#send_link').click(function (e) {
                            e.preventDefault();

                            var tr = $('#table_send').find('tr');
                            var arr_tr = [];
                            var arr_td = [];
                            var abc = [];
                            for(var i=0; i<tr.length; i++){
                                if(i==0) continue;
                                for(var j=0; j<5; j++) {
                                    abc[j] = tr.eq(i).children().eq(j).text();
                                }
                                arr_td.push(abc);
                            }
                            arr_tr.push(arr_td);
                            console.log(arr_tr)
                        })
                    }
                });
            }
        </script>
    </body>
</html>
