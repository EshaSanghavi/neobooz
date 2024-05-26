"use strict";

$('.route-cart-updateResell').on('click', function () {
    var key = $(this).attr('name').split('_')[1]; // Extract item ID from checkbox name
    if($(this).is(':checked') == true) // Get checkbox checked state
    {
        var is_resell = 1;
    }
    else
    {
        var is_resell = 0;
    }
    $.post($('#route-cart-updateResell').data('url'), {
        _token: $('meta[name="_token"]').attr('content'),
        key,
        is_resell,
        resell_price: 0.0,
    }, function (response) {
        if (response.status == 0) {
            toastr.error(response.message, {
                CloseButton: true,
                ProgressBar: true
            });
        } else {
            var message = "successfully_updated!";
            toastr.success(message, {
                CloseButton: true,
                ProgressBar: true
            });
            if(is_resell == 1){
                var elements = document.getElementsByName("resell_price_"+key);
                elements.forEach(function(element) {
                    if (element)
                        element.style.display = 'block';
                });

                document.getElementById("resell_total_"+key).innerText = response.resell_total;
            }
            else{
                var elements = document.getElementsByName("resell_price_"+key);
                elements.forEach(function(element) {
                    if (element)
                        element.style.display = 'none';
                });
                document.getElementById("resell_total_"+key).innerText = response.resell_total;
               
            }
        }
    });
});

$('.route-cart-resellPrice').on('change', function () {
    var key = $(this).attr('name').split('_')[2]; // Extract item ID from checkbox name
    var is_resell = 1;
    var resell_price = this.value;
    $.post($('#route-cart-updateResell').data('url'), {
        _token: $('meta[name="_token"]').attr('content'),
        key,
        is_resell,
        resell_price,
    }, function (response) {
        if (response.status == 0) {
            toastr.error(response.message, {
                CloseButton: true,
                ProgressBar: true
            });
        } else {
            var message = "successfully_updated!";
            toastr.success(message, {
                CloseButton: true,
                ProgressBar: true
            });
            if(is_resell == 1){
                var elements = document.getElementsByName("resell_price_"+key);
                elements.forEach(function(element) {
                    if (element)
                        element.style.display = 'block';
                });

                document.getElementById("resell_total_"+key).innerText = response.resell_total;
            }
            else{
                var elements = document.getElementsByName("resell_price_"+key);
                elements.forEach(function(element) {
                    if (element)
                        element.style.display = 'none';
                });
                
                document.getElementById("resell_total_"+key).innerText = response.resell_total;
            }
        }
    });
});

function updateCartQuantityList(minimum_order_qty, key, incr, e) {
    let quantity_id = 'cart_quantity_web';
    updateCartCommon(minimum_order_qty, key, incr, e, quantity_id);
}

function updateCartQuantityListMobile(minimum_order_qty, key, incr, e) {
    let quantityId = 'cart_quantity_mobile';
    updateCartCommon(minimum_order_qty, key, incr, e, quantityId);
}

function updateCartCommon(minimum_order_qty, key, incr, e, quantity_id) {
    let quantity = parseInt($("#" + quantity_id + key).val()) + parseInt(incr);
    let exQuantity = $("#" + quantity_id + key);
    if (minimum_order_qty > quantity && e != 'delete') {
        toastr.error($('#message-minimum-order-quantity-cannot-less-than').data('text') + minimum_order_qty);
        $(".cartQuantity" + key).val(minimum_order_qty);
        return false;
    }
    if (exQuantity.val() == exQuantity.data('min') && e == 'delete') {
        $.post($('#route-cart-remove').data('url'), {
                _token: $('meta[name="_token"]').attr('content'),
                key: key
            },
            function (response) {
                updateNavCart();
                toastr.info($('#message-item-has-been-removed-from-cart').data('text'), {
                    CloseButton: true,
                    ProgressBar: true
                });
                let segmentArray = window.location.pathname.split('/');
                let segment = segmentArray[segmentArray.length - 1];
                if (segment === 'checkout-payment' || segment === 'checkout-details') {
                    location.reload();
                }
                $('#cart-summary').empty().html(response.data);
                $('[data-toggle="tooltip"]').tooltip()
                actionCheckoutFunctionInit()
                couponCode()
            });
    } else {
        $.post($('#route-cart-updateQuantity').data('url'), {
            _token: $('meta[name="_token"]').attr('content'),
            key,
            quantity
        }, function (response) {
            if (response.status == 0) {
                toastr.error(response.message, {
                    CloseButton: true,
                    ProgressBar: true
                });
                $(".cartQuantity" + key).val(response['qty']);
            } else {
                updateNavCart();
                $('#cart-summary').empty().html(response);
                $('[data-toggle="tooltip"]').tooltip()
                actionCheckoutFunctionInit()
                couponCode()
            }
        });
    }
}

$('.qty_plus').on('click', function () {
    var $qty = $(this).parent().find('input');
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
    }
    quantityListener();
});


$('.qty_minus').on('click', function () {
    var $qty = $(this).parent().find('input');
    var currentVal = parseInt($qty.val());
    if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(currentVal - 1);
    }
    quantityListener();
});


function quantityListener() {
    $('.qty_input').each(function () {
        var qty = $(this);
        var minimumOrderQuantity = $(this).data('minimum-order') ?? 1;
        if (qty.val() == 1 || qty.val() == minimumOrderQuantity ) {
            qty.siblings('.qty_minus').html('<i class="tio-delete text-danger fs-12"></i>')
        } else {
            qty.siblings('.qty_minus').html('<i class="tio-remove"></i>')
        }
    });
}

quantityListener();

cartQuantityInitialize();


function setShippingId(id, cartGroupId) {
    $.get({
        url: $('#route-customer-set-shipping-method').data('url'),
        dataType: 'json',
        data: {
            id: id,
            cart_group_id: cartGroupId
        },
        beforeSend: function () {
            $('#loading').show();
        },
        success: function () {
            location.reload();
        },
        complete: function () {
            $('#loading').hide();
        },
    });
}
