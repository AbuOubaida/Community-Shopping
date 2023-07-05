<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="zytheme" />
{{--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />--}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elegant Restaurant & Cafe Html5 Template" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link href="{{url("client-site//images/favicon/favicon.png")}}" rel="icon" />--}}
@if(\Request::url() == route('invoice'))
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
@else
    <x-client._header_link/> <!--Components from views -->
@endif
    <title>{{$headerData['app']}} || {{$headerData['role']}} || {{$headerData['title']}}</title>
    <script>
        function imageZoom(imgID, resultID) {
            let img, lens, result, cx, cy;
            img = document.getElementById(imgID);
            result = document.getElementById(resultID);
            /*create lens:*/
            lens = document.createElement("DIV");
            lens.setAttribute("class", "img-zoom-lens");
            /*insert lens:*/
            img.parentElement.insertBefore(lens, img);
            /*calculate the ratio between result DIV and lens:*/
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;
            /*set background properties for the result DIV:*/
            result.style.backgroundImage = "url('" + img.src + "')";
            result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
            img.onmouseover = function (){mouseOver()}
            lens.onmouseover = function (){mouseOver()}
            img.onmouseout = function (){mouseOut()}
            lens.onmouseout = function (){mouseOut()}
            function mouseOver() {
                result.style.zIndex = 111;
            }
            function mouseOut() {
                result.style.zIndex = -1;
            }
            /*execute a function when someone moves the cursor over the image, or the lens:*/
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mousemove", moveLens);
            /*and also for touch screens:*/
            lens.addEventListener("touchmove", moveLens);
            img.addEventListener("touchmove", moveLens);
            function moveLens(e) {
                var pos, x, y;
                /*prevent any other actions that may occur when moving over the image:*/
                e.preventDefault();
                /*get the cursor's x and y positions:*/
                pos = getCursorPos(e);
                /*calculate the position of the lens:*/
                x = pos.x - (lens.offsetWidth / 2);
                y = pos.y - (lens.offsetHeight / 2);
                /*prevent the lens from being positioned outside the image:*/
                if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
                if (x < 0) {x = 0;}
                if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
                if (y < 0) {y = 0;}
                /*set the position of the lens:*/
                lens.style.left = x + "px";
                lens.style.top = y + "px";
                /*display what the lens "sees":*/
                result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
            }
            function getCursorPos(e) {
                var a, x = 0, y = 0;
                e = e || window.event;
                /*get the x and y positions of the image:*/
                a = img.getBoundingClientRect();
                /*calculate the cursor's x and y coordinates, relative to the image:*/
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /*consider any page scrolling:*/
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {x : x, y : y};
            }
        }
    </script>
</head>
<body>
    @if(\Request::url() == route('invoice'))

    @else
    <div id="wrapper" class="wrapper clearfix">
        <x-client._header_nav /> {{--<header navigation section>--}} <!--Components from views -->
    @endif
        @yield('content') <!-- all page load here-->
    @if(\Request::url() == route('invoice'))
    @else
        <div class="clearfix"></div>
        <x-client._footer/> <!--Components from views -->
        <div id='ajax_loader' style="position: fixed; left: 40%; top: 20%;z-index: 100; display: none">
            <img width="50%" src="{{url('assets/back-end/loder/loading1.gif')}}"/>
        </div>
    @endif

    </div>
    @if(\Request::url() == route('invoice'))
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
{{--        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>--}}
{{--        <script>--}}
{{--            $(function() {--}}
{{--                let doc = new jsPDF();--}}
{{--                let specialElementHandlers = {--}}
{{--                    '#editor': function (element, renderer) {--}}
{{--                        return true;--}}
{{--                    }--}}
{{--                };--}}
{{--                $('#print').click(function () {--}}
{{--                    doc.fromHTML($('#invoice').html(), 15, 15, {--}}
{{--                        'width': 900,--}}
{{--                        'elementHandlers': specialElementHandlers--}}
{{--                    });--}}
{{--                    doc.save('sample-file.pdf');--}}
{{--                });--}}
{{--            });--}}
{{--        </script>--}}
    @else
        <x-client._footer_link/> <!--Components from views -->
    @endif

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
    <script>
        // Initiate zoom effect:
        imageZoom("product-src", "product-preview");
    </script>
</body>
</html>
