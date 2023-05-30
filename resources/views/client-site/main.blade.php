<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="zytheme" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Elegant Restaurant & Cafe Html5 Template" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link href="{{url("client-site//images/favicon/favicon.png")}}" rel="icon" />--}}
    <x-client._header_link/> <!--Components from views -->

    <title>{{$headerData['app']}} || {{$headerData['role']}} || {{$headerData['title']}}</title>
</head>
<body>

<div id="wrapper" class="wrapper clearfix">
    <x-client._header_nav /> {{--<header navigation section>--}} <!--Components from views -->
    @yield('content') <!-- all page load here-->
    <div class="clearfix"></div>
    <x-client._footer/> <!--Components from views -->
    <div id='ajax_loader' style="position: fixed; left: 40%; top: 20%;z-index: 100; display: none">
        <img width="50%" src="{{url('assets/back-end/loder/loading1.gif')}}"/>
    </div>
</div>
<x-client._footer_link/> <!--Components from views -->
<script type="text/javascript">
    $(".update-cart-minus").click(function (e){
        e.preventDefault();
        let ele = $(this);
        let price = ele.attr('data-price')
        let total = $('#total').attr('data-total')
        let OrderTotal = $('#order-total').attr('data-total')
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val(),op:'dec'},
            success: function (response) {
                if(parseInt(ele.parents("tr").find(".quantity").val()) > 1)
                {
                    ele.parents("tr").find(".quantity").val(response)
                    $("#p-"+ele.attr("data-id")).html("BDT "+(price * response))
                    let res = (total-price)
                    let resTotal = (OrderTotal-price)
                    $("#total").text('BDT '+ res +'/=')
                    $("#total").attr('data-total',res)
                    $("#order-total").text('BDT '+ resTotal + '/=')
                    $("#order-total").attr('data-total',resTotal)
                }else {
                    alert("Quantity can't less than 1!")
                }
            }
        });
    })
    $(".update-cart-plus").click(function (e){
        e.preventDefault();
        let ele = $(this);
        let price = ele.attr('data-price')
        let total = $('#total').attr('data-total')
        let OrderTotal = $('#order-total').attr('data-total')
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val(),op:'inc'},
            success: function (response) {
                if(parseInt(ele.parents("tr").find(".quantity").val()) < 5)
                {
                    ele.parents("tr").find(".quantity").val(response)
                    $("#p-"+ele.attr("data-id")).html("BDT "+(price * response))
                    let anotherRes = (parseInt(total) + parseInt(price));
                    let resTotal = (parseInt(OrderTotal) + parseInt(price))
                    $('#total').text('BDT '+ anotherRes +'/=')
                    $("#total").attr('data-total',anotherRes)
                    $("#order-total").text('BDT '+ resTotal + '/=')
                    $("#order-total").attr('data-total',resTotal)
                }else {
                    alert("Quantity can't greater than 5!")
                }
            }
        });
    })
    // this function is for update card
    $(".update-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
            success: function (response) {
                window.location.reload();
            }
        });
    });
    $(".cart-product-remove").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        if(confirm("Are you sure")) {
            $.ajax({
                url: '{{ route('delete.cart') }}',
                method: "DELETE",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                success: function (response) {
                    window.location.reload();

                }
            });
        }
    });
</script>
</body>
</html>
