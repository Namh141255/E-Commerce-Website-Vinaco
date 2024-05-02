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
})