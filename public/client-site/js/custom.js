let Product = {};
let _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
// let sourceDir = ""; // for localhost "/OFDS/public"
(function ($){
    $(document).ready(function(){
        Product = {
            // Change Country action
            addToCard:function (e,actionID){
                let id = $(e).attr('ref')
                let url = window.location.origin + sourceDir + "/add-to-cart";
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data: {'_token': $('input[name="_token"]').val(),"id":id},
                    success:function (data)
                    {
                        $("#"+actionID).html(data)
                        $(e).hide()
                        $(e).parent().html('<a style="cursor: pointer" href="' + window.location.origin + sourceDir + '/shop-cart" class="btn btn--primary">View Cart</a>')
                    }
                });
                return false;
            },
            // Change shopping card delivery address
            changeAddress:function (e)
            {
                let val = $(e).val()
                let url = window.location.origin + sourceDir + "/change-address";
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data:{"value":val},
                    success:function (data)
                    {
                        $('#card_total').html(data)
                    }
                })
            },
            // File type Image and type validation
            mustImage:function (e,size)
            {
                // console.log(e.type)
                if (e.type == "file") {
                    let input = $(e);
                    let file = input[0].files;
                    // alert(file[0].type)
                    if (file[0].size / 1024 > size)
                    {
                        alert('Image size must be less then 2MB')
                        return false
                    }
                    if ((file[0].type == 'image/jpeg' || file[0].type == 'image/jpg' || file[0].type == 'image/png'|| file[0].type == 'image/webp'))
                    {
                        return true
                    }else {
                        alert('Image Type must be .jpeg|.jpg|.png|.webp')
                        return false
                    }
                    return false
                }
                return false
            }

        }
    })
}(jQuery));


