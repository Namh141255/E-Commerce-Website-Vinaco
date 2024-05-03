$(document).ready(function(){
//     $("#sort").on('change',function(){
//         this.form.submit();
//     })

    //Get Product Price base on Style
    $(".getPrice").change(function(){
        var style = $(this).val();
        var product_id = $(this).attr("product-id");
        // alert(product_id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-attribute-price',
            data:{style:style,product_id:product_id},
            type:'post',
            success:function(resp){
                // alert(resp)
                if(resp['discount']>0){
                    $(".getAttributePrice").html("<span class='pd-detail__price'>$"+resp['final_price']+"</span><span class='pd-detail__discount'>("+resp['discount_percent']+ "% OFF)</span><del class='pd-detail__del'>$"+resp['product_price']+"</del>")
                }else{
                    $(".getAttributePrice").html("<span class='pd-detail__price'>$"+resp['final_price']+"</span>");
                }
            },error:function(){
                alert("Error");
            }
        })
    })

    //Add to Cart
    $("#addToCart").submit(function(){
        var formData = $(this).serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/add-to-cart',
            type:'post',
            data:formData,
            success:function(resp){
                $(".totalCartItems").html(resp['totalCartItems']);
                $("#appendCartItems").html(resp.view);
                $("#appendMiniCartItems").html(resp.minicartview);
                if(resp['status']==true){
                    // alert(resp['message']);
                    $('.print-success-msg').show();
                    $('.print-success-msg').delay(3000).fadeOut('slow');
                    $('.print-success-msg').html("<div class='success'><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>"+resp['message']+"</div>");
                }else{
                    // alert(resp['message']);
                    $('.print-error-msg').show();
                    $('.print-error-msg').delay(3000).fadeOut('slow');
                    $('.print-error-msg').html("<div class='alert'><span class='closebtn' onclick='this.parentElement.style.display='none';'>&times;</span>"+resp['message']+"</div>");
                }
            },error:function(){
                alert("Error");
            }
        });
    })

    //Update Cart Item
    $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('fa-plus')){
            //Get Qty
            var quantity = $(this).data('qty')
            //Increase qty by 1
            new_qty = parseInt(quantity)+1;
        }
        if($(this).hasClass('fa-minus')){
            //Get Qty
            var quantity = $(this).data('qty')

            //Check qty is atleast 1
            if(quantity<=1){
                alert("Item Quantity must be 1 or greater");
                return false;
            }
            //Increase qty by 1
            new_qty = parseInt(quantity)-1;
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/update-cart-item-qty',
            type:'post',
            data:{cartid:cartid,new_qty:new_qty},
            success:function(resp){
                // alert(resp);
                $(".totalCartItems").html(resp.totalCartItems);
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
                $("#appendMiniCartItems").html(resp.minicartview);
            },error:function(resp){
                alert("Error");
            }
        });
    })

    //Delete Cart Item
    $(document).on('click','.deleteCartItem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this Cart Item?")
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/delete-cart-item',
                type:'post',
                data:{cartid:cartid},
                success:function(resp){
                    // alert(resp);
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);  
                    $("#appendMiniCartItems").html(resp.minicartview);  
                },error:function(resp){
                    alert("Error");
                }
            })
        }
    })

    //empty Cart
    $(document).on('click','.emptyCart',function(){
        var result = confirm("Are you sure to empty your this Cart Item?")
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:'/empty-cart',
                type:'post',
                success:function(resp){
                    // alert(resp);
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);  
                    $("#appendMiniCartItems").html(resp.minicartview);  
                },error:function(resp){
                    alert("Error");
                }
            })
        }
    })

    //Register Form Validation
    $("#registerForm").submit(function(){
        $(".loader").show();
        var formData = $("#registerForm").serialize();
        $.ajax({
            url:'/user/register',
            type:'post',
            data:formData,
            success:function(data){
                if(data.type=="validation"){
                    $(".loader").hide();
                    $.each(data.errors,function(i,error){
                        $('#register-'+i).attr('style','color:red')
                        $('#register-'+i).html(error)
                        setTimeout(function(){
                            $('#register-'+i).css({
                                'display':'none'
                            })
                        },3000);
                    })
                }else if(data.type=="success"){
                    $(".loader").hide();
                    window.location.href=data.redirectUrl;
                }
            },error:function(){
                alert("Error");
            }
        })
    })

    //Login Form Validadion
    $("#loginForm").submit(function(){
        var formData = $(this).serialize();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/user/login',
            type:'post',
            data:formData,
            success:function(resp){
                // alert(resp);
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $('.login-'+i).attr('style','color:red')
                        $('.login-'+i).html(error)
                        setTimeout(function(){
                            $('.login-'+i).css({
                                'display':'none'
                            })
                        },3000);
                    })
                }else if(resp.type=="inactive"){
                    $('#login-error').attr('style','color:red')
                    $('#login-error').html(resp.message)
                }else if(resp.type=="incorrect"){
                    $('#login-error').attr('style','color:red')
                    $('#login-error').html(resp.message)
                }else if (resp.type=="success"){
                    window.location.href=resp.redirectUrl;
                }
            },error:function(){
                alert("Error");
            }
        })
    })

    //Account Form Validation
    $("#accountForm").submit(function(){
        $(".loader").show();
        var formData = $(this).serialize();
        $.ajax({
            url:'/user/account',
            type:'post',
            data:formData,
            success:function(data){
                if(data.type=="validation"){
                    $(".loader").hide();
                    $.each(data.errors,function(i,error){
                        $('#account-'+i).attr('style','color:red')
                        $('#account-'+i).html(error)
                        setTimeout(function(){
                            $('#account-'+i).css({
                                'display':'none'
                            })
                        },3000);
                    })
                }else if(data.type=="success"){
                    $(".loader").hide();
                    $('#account-success').attr('style','color:green')
                    $('#account-success').html(data.message)
                }
            },error:function(){
                alert("Error");
            }
        })
    })
})