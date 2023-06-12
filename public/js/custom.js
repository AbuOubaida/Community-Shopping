let Obj = {};
let sourceDir = null;
if(window.location.port)
{
    sourceDir = "";
}else{
    sourceDir = "/OFDS/public";
}
 // for localhost "/OFDS/public"
(function ($){
    $(document).ajaxStop(function(){
        $("#ajax_loader").hide();
    });
    $(document).ajaxStart(function (){
        $("#ajax_loader").show();
    });
    $(document).ready(function (){
        $("#shipping-submit").click(function (e){
            e.preventDefault()
            let type = $("#locationType").val()
            let location = $("#location").val()
            let amount = $("#amount").val()
            let url = window.location.origin + sourceDir + "/superadmin/protocol/shipping/set-shipping-charge";
            if (type !== "0" && location !== "0" && amount.length !== 0)
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: url,
                    type: "POST",
                    data: {'type': type, 'location': location, 'amount': amount},
                    success: function (data)
                    {
                        try {
                            data = JSON.parse(data)
                            alert(data.error.msg)
                        }catch (e)
                        {
                            $("#datatablesSimple").html(data)
                            alert('Data added successfully!')
                        }
                    }
                })
            }
            else {
                alert("Empty field error!")
            }
        })
        $("#shipping-update").click(function (e){
            e.preventDefault()
            let ref = $(this).attr('ref')
            let type = $("#locationType").val()
            let location = $("#location").val()
            let amount = $("#amount").val()
            let url = window.location.origin + sourceDir + "/superadmin/protocol/shipping/edit-shipping-charge/"+ref;
            if (type !== "0" && location !== "0" && amount.length !== 0)
            {
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: url,
                    type: "POST",
                    data: {'type': type, 'location': location, 'amount': amount},
                    success: function (data)
                    {
                        try {
                            data = JSON.parse(data)
                            alert(data.error.msg)
                        }catch (e)
                        {
                            window.location.reload()
                            alert('Data update successfully!')
                        }
                    }
                })
            }
            else {
                alert("Empty field error!")
            }
        })
    })
    $(document).ready(function(){
        Obj = {
            // Change Country action
            country:function (e,actionID){
                let value = $(e).val();
                $("#"+actionID).html("<option></option>");
                if (value === 'Bangladesh')
                {
                    let url = window.location.origin + sourceDir + "/hidden-dirr/get-division";
                    $.getJSON({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        type:"POST",
                        data: {"value": value},
                        success:function (data)
                        {
                            let pId = actionID.replace("list",'');
                            $("#"+pId).val('');
                            if (data.error){
                                // throw data.error.msg;
                                let division = "<option></option>";
                                $("#"+actionID).append(division);
                                // alert(data.error.msg)
                            }else{
                                $(data.results).each(function (){
                                    let division = "<option value=\"" + this.name + "\">" + this.name +"</option>";
                                    $("#"+actionID).append(division);
                                });
                            }
                        }
                    });
                }
            },
            //Change division action
            division:function (e,actionID){
                let val = $(e).val();
                let url = window.location.origin + sourceDir + "/hidden-dirr/get-district";
                $.getJSON({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data:{"value":val},
                    success:function (data)
                    {
                        let pId = actionID.replace("list",'');
                        $("#"+pId).val('');
                        // console.log(data)
                        if (data.error){
                            // throw data.error.msg;
                            alert(data.error.msg)
                        }else{
                            $("#"+actionID).html("<option></option>");
                            $(data.results).each(function (){
                                let district = "<option value=\"" + this.name + "\">" + this.name +"</option>";
                                $("#"+actionID).append(district);
                            });
                        }
                    }
                });
            },
            //Change District action
            district:function (e,actionID){
                let val = $(e).val();
                let url = window.location.origin + sourceDir + "/hidden-dirr/get-upazila";
                $.getJSON({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data:{"value":val},
                    success:function (data)
                    {
                        let pId = actionID.replace("list",'');
                        $("#"+pId).val('');
                        // console.log(data)
                        if (data.error){
                            // throw data.error.msg;
                            alert(data.error.msg)
                        }else{
                            $("#"+actionID).html("<option></option>");
                            $(data.results).each(function (){
                                let upazilla = "<option value=\"" + this.name + "\">" + this.name +"</option>";
                                $("#"+actionID).append(upazilla);
                            });
                            $(data.results2).each(function (){
                                let citys = "<option value=\"" + this.name + "\">" + this.name +"</option>";
                                $("#"+actionID).append(citys);
                            });
                        }
                    }
                });
            },
            //Change Upazilla action
            upazilla:function (e,actionID,actionID2){
                let val = $(e).val();
                let url = window.location.origin + sourceDir + "/hidden-dirr/get-zip";
                $.getJSON({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data:{"value":val},
                    success:function (data)
                    {
                        // let pId = actionID.replace("list",'');
                        $("#zip_code").val('');
                        let pId2 = actionID2.replace("list",'');
                        $("#"+pId2).val('');
                        // console.log(data)
                        if (data.error){
                            // throw data.error.msg;
                            alert(data.error.msg)
                        }else{
                            $("#"+actionID).html("<option></option>");
                            $(data.zipCods).each(function (){
                                let zip = "<option value=\"" + this.PostCode + "\"> (" + this.PostCode +")"+ this.SubOffice +"</option>";
                                $("#"+actionID).append(zip);
                            });
                            $("#"+actionID2).html("<option></option>");
                            $(data.unions).each(function (){
                                let union = "<option value=\"" + this.name + "\">" + this.name +"</option>";
                                $("#"+actionID2).append(union);
                            });
                        }
                    }
                });
            },
            shippingCharge:function (e,thisType,countryID,DivisionID,DistrictID,UpazilaID,UnionID){
                let country = $("#"+countryID).val();
                let division = $("#"+DivisionID).val();
                let district = $("#"+DistrictID).val();
                let upazila = $("#"+UpazilaID).val();
                let union = $("#"+UnionID).val();
                let value = null;
                let type = null;
                if (union.length > 3)
                {
                    //Union has
                    type = 5
                    value = union
                }else if(upazila.length > 3)
                {
                    //Upazila has
                    type = 4
                    value = upazila
                }else if(district.length > 3)
                {
                    //District has
                    type = 3
                    value = district
                }else if(division.length > 3)
                {
                    //Division has
                    type = 2
                    value = division
                }else {
                    type = 1
                    value = country
                }
                if ((type != null) && (value != null))
                {
                    let word = $("#word_no").val()
                    let village = $("#village").val()
                    let url = window.location.origin + sourceDir + "/hidden-dirr/get-shipping";
                    $.ajax({
                        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url:url,
                        type:"POST",
                        data:{"value":value,"type":type},
                        success:function (data)
                        {

                        }
                    })
                }
            },
            // Upload image preview
            priview:function (e,id){
                let file = $(e).get(0).files[0];
                if(file){
                    let reader = new FileReader();
                    reader.onload = function(){
                        $("#"+id).attr("src", reader.result);
                    }

                    reader.readAsDataURL(file);
                }
            },
            LocationType:function (e,id){
                let value = $(e).val();
                let url = window.location.origin + sourceDir + "/hidden-dirr/location-type";
                $.ajax({
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:url,
                    type:"POST",
                    data:{"value":value},
                    success:function (data)
                    {
                        // console.log(data)
                        $("#"+id).html(data)
                    }
                })
            },
        }
    })
}(jQuery));


